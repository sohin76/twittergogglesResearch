<?php

// TwitterGoggles - collects tweets using the twitter search API and stores
// them in a relational database.
//
// Group Informatics Research Lab, Open source
// Original PhP Code and database Developed by Alan Black with contributions from 
// Christopher Mascaro, Michael Gallagher & Sean Goggins

//
// Initialize/Startup
//

date_default_timezone_set('UTC');
$date = date("Y-m-d H:i:s");
echo("vvv Start: $date\n");

// Set logging level
if (in_array("-v", $argv)) {
 	echo("verbose mode\n");
 	$log_level = 2;
} else {
 	//echo("terse mode\n");
 	$log_level = 1;
}

// Get head #
// In the job table there is a field called "head".  When 
// this program is run from UNIX CRON, one of the parameters
// passed to it is the head.  So, there will be n
// "heads" running, and we need there to be a head for
// each head in the job table.
// presently, these heads are 1 through 4.  they exist
// on different amazon ec2 servers to manage rate limiting
// by IP address at twitter.  
// rate limits are changing in the 1.1 API, so how this
// job scheduling happens needs to be rethought.  We are limited
// to 180 requests per 15 minute window in the 1.1 API.  SO,
// that would be 180 specific queries 
$options = getopt("h:d::");  // removed i:
//var_dump($options);
$head = $options['h'];
//$interface = $options['i'];
// delay exists so that all the heads are hitting the job table
// at different times during the course of a minute
// delay is in seconds 
$delay = $options['d'];
echo "Head: $head \n";
//echo "Interface: $interface \n";
echo "Delay: $delay \n";

// Initialize variables
$fixed_search_params = '&rpp=100&include_entities=1';
$retry_limit = 3;
$http_response_header = NULL;
$run_total_count = 0;
$epoch_min = floor(time()/60); // minutes since the Unix Epoch (January 1 1970 00:00:00 GMT)
if ($log_level >= 2) {
	echo("epoch min.: $epoch_min\n");
}

// Delay execution
sleep($delay);

//
// Establish database connection
//

// Connect to server
echo("Connect to server\n");
// this db connect string should be configured as something that reads a 
// config/text file, not hard coded in the php
$db_connection = mysql_connect('xxxxxxxxxxxx','xxxxx','xxxxx');
if (!$db_connection) {
    die('*** Error: could not connect to database: ' . mysql_error() . "\n");
}

// Set UTF-8 Unicode for MySQL transactions
// UTF8 is required for 
echo("Set UTF-8 Unicode for MySQL transactions\n");
$db_set_charset_result = mysql_set_charset ('utf8');
if (!$db_set_charset_result) {
    die('*** Error: could not set character set: ' . mysql_error() . "\n");
}

// Select database (schema)
echo("Select database (schema)\n");
$db_select_result = mysql_select_db('tzn3');
if (!$db_select_result) {
    die('*** Error: could not select database: ' . mysql_error() . "\n");
}

//
// Get jobs
//

$job_select_query = "SELECT * FROM job WHERE state>0 AND zombie_head=$head ORDER BY job_id";
$job_select_result = mysql_query($job_select_query);
if (!$job_select_result) {
    die('*** Error: could not fetch jobs: ' . mysql_error() . "\n");
}

//
// Iterate through jobs
//

while ($row = mysql_fetch_assoc($job_select_result)) {
	// Get job parameters
    $job_id = $row['job_id'];
    $job_state = $row['state'];
    $job_query = $row['query'];
    $job_since_id = $row['since_id_str'];
    $job_description = $row['description'];
    
    // Check run frequency
    if (($epoch_min % $job_state) != 0) {
    	continue; // jump out of job control while loop - don't run job
    }
    
    echo("+++ Job ID: $job_id   Description: $job_description   Query: $job_query\n"); 

	//
	// Iterate through tweets (page by page if required)
	//
	
	// Initial search
	// - uses since_id from DB (0 for new jobs)
	// - max_id is not used (max_id is returned, used later for "page" searches)
	// - page is not used (used later for "page" searches)

	// The 1.1 API replaces "page" with "count"
	// results_per_page will soon become the count field 
	
	$twitter_query = $job_query
		. "&since_id=" . $job_since_id
		. $fixed_search_params;
	if ($log_level >= 2) {
		echo("init query: $twitter_query \n");
	}
	
	$url = "http://search.twitter.com/search.json?$twitter_query";
	$curlh = curl_init($url);
	//curl_setopt($curlh, CURLOPT_VERBOSE, TRUE);
	curl_setopt($curlh, CURLOPT_RETURNTRANSFER, TRUE);
	//curl_setopt($curlh, CURLOPT_INTERFACE, $interface);

	$try = 1;
	//$json = @file_get_contents("http://search.twitter.com/search.json?$twitter_query");
	$json = curl_exec($curlh);

	while (!$json AND $try<$retry_limit) {
		echo("*** Error: twitter init search failure - try " . $try . ": "
		. $http_response_header[0] . "\n"); // FIXXXXXXXXXXXXX
		sleep(2^($try-1));
		$try++;
		$json = curl_exec($curlh);
	}
	
	if (!$json) {
		$decode = NULL;
		echo("*** Error: twitter init search failure - try " . $try . ": "
		. $http_response_header[0] . "\n");
	} else {
		$decode = json_decode($json, true); //getting the file content as array
	}
	
	$max_id = $decode["max_id_str"];
	if ($log_level >= 2) {
		echo("max_id: $max_id \n");
	}
	$page = 2; // init/reset page counter to 2
	$total_results = 0;
	
	// Enter results processing / next page loop
	while(!empty($decode["results"])){
		$result_count = count($decode["results"]);
		$total_results = $total_results + $result_count;
		
		//
		// Iterate through results
		//
		foreach($decode["results"] as $result) {
		//print_r($result);
			// Add data to tweet table
			if($result['geo']['type']=="Point"){
				$tweet_update_query = "INSERT INTO tweet (tweet_id_str, job_id, created_at, text, from_user, from_user_id_str, from_user_name, to_user, to_user_id_str, to_user_name, source, iso_language, location_geo, location_geo_0, location_geo_1)";
			} else {
				$tweet_update_query = "INSERT INTO tweet (tweet_id_str, job_id, created_at, text, from_user, from_user_id_str, from_user_name, to_user, to_user_id_str, to_user_name, source, iso_language)";
			}
			$tweet_update_query = $tweet_update_query 
			. " VALUES ('" . $result['id_str']
			. "', '" . $job_id
			. "', '" . date( 'Y-m-d H:i:s', strtotime($result['created_at']))
			. "', '" . mysql_real_escape_string(html_entity_decode($result['text']))
			. "', '" . mysql_real_escape_string($result['from_user'])
			. "', '" . $result['from_user_id_str']
			. "', '" . mysql_real_escape_string($result['from_user_name'])
			. "', '" . mysql_real_escape_string($result['to_user'])
			. "', '" . $result['to_user_id_str']
			. "', '" . mysql_real_escape_string($result['to_user_name'])
			. "', '" . mysql_real_escape_string(html_entity_decode($result['source']))
			. "', '" . $result['iso_language_code'] . "'";
			
			if($result['geo']['type']=="Point"){
				$my_geo = "point(" . $result['geo']['coordinates'][0] . "," . $result['geo']['coordinates'][1] . ")";
				$my_geo_0 = $result['geo']['coordinates'][0];
				$my_geo_1 = $result['geo']['coordinates'][1];
			
				$tweet_update_query = $tweet_update_query . ", " . $my_geo
				. ", " . $my_geo_0
				. ", " . $my_geo_1;
			}
			
			$tweet_update_query = $tweet_update_query . ")";
			
			//echo("q " . $tweet_update_query . "\n");
			$tweet_update_result = mysql_query($tweet_update_query);
			if (!$tweet_update_result) {
				if ($log_level >= 2) {
					echo('>>> Warning: Could not add tweet: ' . mysql_error() . "\n");
    				echo('    Query: ' . $tweet_update_query . "\n");
    			} 
    		} else {
    		
				// Process hashtags
				if(!empty($result['entities']['hashtags'])){
					foreach($result['entities']['hashtags'] as $hashtag) {
						//echo("hashtag: " . $hashtag['text'] . "\n");
						$hashtag_query = "INSERT INTO hashtag (tweet_id, job_id, text, index_start, index_end)"
						. " VALUES ('" . $result['id_str']
						. "', '" . $job_id
						. "', '" . mysql_real_escape_string($hashtag['text'])
						. "', '" . $hashtag['indices'][0]
						. "', '" . $hashtag['indices'][1]
						. "')";
						$hashtag_query_result = mysql_query($hashtag_query);
						if (!$hashtag_query_result) {
							if ($log_level >= 2) {
								echo('>>> Warning: Could not add hashtag: ' . mysql_error() . "\n");
								echo('    Query: ' . $hashtag_query . "\n");
							}
						}
					}
				}
				
				// Process mentions
				if(!empty($result['entities']['user_mentions'])){
					foreach($result['entities']['user_mentions'] as $mention) {
						//echo("mention: " . $mention['screen_name'] . "\n");
						$mention_query = "INSERT INTO mention (tweet_id, job_id, screen_name, name, id_str, index_start, index_end)"
						. " VALUES ('" . $result['id_str']
						. "', '" . $job_id
						. "', '" . mysql_real_escape_string($mention['screen_name'])
						. "', '" . mysql_real_escape_string($mention['name'])
						. "', '" . $mention['id_str']
						. "', '" . $mention['indices'][0]
						. "', '" . $mention['indices'][1]
						. "')";
						$mention_query_result = mysql_query($mention_query);
						if (!$mention_query_result) {
							if ($log_level >= 2) {
								echo('>>> Warning: Could not add mention: ' . mysql_error() . "\n");
								echo('    Query: ' . $mention_query . "\n");
							}
						}
					}
				}
				
				// Process URLs
				if(!empty($result['entities']['urls'])){
					foreach($result['entities']['urls'] as $url) {
						//echo("url: " . $url['display_url'] . "\n");
						$url_query = "INSERT INTO url (tweet_id, job_id, url, expanded_url, display_url, index_start, index_end)"
						. " VALUES ('" . $result['id_str']
						. "', '" . $job_id
						. "', '" . mysql_real_escape_string($url['url']);
						if(array_key_exists('expanded_url', $url)) {  // expanded_url is sometimes missing!
							$url_query = $url_query . "', '" . mysql_real_escape_string($url['expanded_url']);
						} else {
							$url_query = $url_query . "', '";
						}
						if(array_key_exists('display_url', $url)) {  // display_url is sometimes missing!
							$url_query = $url_query . "', '" . mysql_real_escape_string($url['display_url']);
						} else {
							$url_query = $url_query . "', '";
						}
						$url_query = $url_query . "', '" . $url['indices'][0]
						. "', '" . $url['indices'][1]
						. "')";
						$url_query_result = mysql_query($url_query);
						if (!$url_query_result) {
							if ($log_level >= 2) {
								echo('>>> Warning: Could not add URL: ' . mysql_error() . "\n");
								echo('    Query: ' . $url_query . "\n");
							}
						}
					}
				}
			} // end if got results
		} // end foreach loop
		
		// Check to see if next page search is needed
		if ($page > 15) {
			break;
		}
		
		// "Page" search
		// - uses since_id from DB (0 for new jobs)
		// - max_id is returned from initial search (it "locks" paging mechanism)
		// - page parameter begins at 2 
		// - note: last page (<15) could return rpp results, next will have 0 results
		$twitter_query = $job_query
			. "&since_id=" . $job_since_id
			. "&max_id=" . $max_id
			. "&page=" . $page
			. $fixed_search_params;
		if ($log_level >= 2) {
			echo("page query: $twitter_query \n");
		}
		
		$try = 1;
		$json = @file_get_contents("http://search.twitter.com/search.json?$twitter_query");
		while (!$json AND $try<$retry_limit) {
		echo("*** Error: twitter page search failure - try " . $try . ": "
		. $http_response_header[0] . "\n");
		sleep(2^($try-1));
			$try++;
			$json = @file_get_contents("http://search.twitter.com/search.json?$twitter_query");
		}
		
		if (!$json) {
			$decode = NULL;
			echo("*** Error: twitter page search failure - try " . $try . ": "
			. $http_response_header[0] . "\n");
		} else {
			$decode = json_decode($json, true); //getting the file content as array
		}
		
		$page = $page + 1;
	}
	
	echo("result count: " . $total_results . "\n");
	$run_total_count = $run_total_count + $total_results;
		
	// Update job's since_id (using max_id)
	if (!empty($decode)) {
		$job_update_query = "UPDATE job SET since_id_str=" . $decode["max_id_str"] 
		. ", last_count=" . $total_results
		. ", last_run='" . date('Y-m-d H:i:s') . "'"
		. " WHERE job_id=$job_id";
		$job_update_result = mysql_query($job_update_query);
		if (!$job_update_result) {
			echo('*** Error: could not update since id: ' . mysql_error() . "\n");
		}
	}
}

//
// Finish
//

mysql_close($db_connection);

echo('$$$ Run total count: ' . $run_total_count . "\n");

$date = date("Y-m-d H:i:s");
echo("^^^ Stop: $date\n\n");
?>
