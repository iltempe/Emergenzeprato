<?php

//tweeter per temperature @pratopioggia
//by MT

// Include twitteroauth
require_once('twitteroauth.php');

// Set keys
$consumerKey = '';
$consumerSecret = '';
$accessToken = '';
$accessTokenSecret = '';

date_default_timezone_set('UTC');
$today = date("Ymd");                           // data di oggi
print_r("Pratopioggia Temperature - Oggi è il ".$today);

// Create object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);


//monitoraggio temperatura

//prato
$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:ITOSCANA124.json"); 
$parsed_json = json_decode($json_string); 
$location = $parsed_json->{'location'}->{'city'}; 
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$tweetMessage="Temperatura attuale misurata in zona Prato Est: ${temp_c}";
$tweet->post('statuses/update', array('status' => $tweetMessage));

sleep(60);

//carmignano
$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPRATOTO3.json"); 
$parsed_json = json_decode($json_string); 
$location = $parsed_json->{'location'}->{'city'}; 
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$tweetMessage="Temperatura attuale misurata in zona Carmignano: ${temp_c}";
$tweet->post('statuses/update', array('status' => $tweetMessage));

sleep(60);

//vaiano sofignano
$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPOVAIAN2.json"); 
$parsed_json = json_decode($json_string); 
$location = $parsed_json->{'location'}->{'city'}; 
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$tweetMessage="Temperatura attuale misurata in zona Vaiano Sofignano: ${temp_c}";
$tweet->post('statuses/update', array('status' => $tweetMessage));

sleep(60);

//vaiano schignano
$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPRATOVA2.json"); 
$parsed_json = json_decode($json_string); 
$location = $parsed_json->{'location'}->{'city'}; 
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$tweetMessage="Temperatura attuale misurata in zona Vaiano Schignano: ${temp_c}";
$tweet->post('statuses/update', array('status' => $tweetMessage));

sleep(60);

//montepiano vernio
$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPOMONTE2.json"); 
$parsed_json = json_decode($json_string); 
$location = $parsed_json->{'location'}->{'city'}; 
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$tweetMessage="Temperatura attuale misurata in zona Montepiano Vernio: ${temp_c}";
$tweet->post('statuses/update', array('status' => $tweetMessage));

//Fonte
//http://www.wunderground.com/weather/api/
//https://github.com/alfcrisci/WU_weather_list/blob/master/WU_stations.csv

?>