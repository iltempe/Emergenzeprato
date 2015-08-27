<?php

//Tweet previsioni per domani
//by MT

include(dirname(__FILE__).'/../settings.php');
include(dirname(__FILE__).'/../getting.php');

// Include twitteroauth
require_once('twitteroauth.php');

// Set keys
$consumerKey = CONSUMER_KEY;
$consumerSecret = CONSUMER_SECRET;
$accessToken = ACCESS_TOKEN;
$accessTokenSecret = ACCESS_TOKEN_SECRET;

$data=new getdata();

$lamma_tweet=("Previsioni domani #meteo #Lamma #prato: " .$data->lamma_text("domani"));
$biometeo_ita_tweet=("Previsioni domani #Biometeo #prato: " .$data->biometeo_ita_text("domani"));
$biometeo_eng_tweet=("Forecast tomorrow #Biometeo #prato: " .$data->biometeo_eng_text("domani"));

// Create object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$tweetMessage = $lamma_tweet;

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
}

sleep(30);

// Set status message
$tweetMessage = $biometeo_ita_tweet;

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
}

sleep(30);

// Set status message
$tweetMessage = $biometeo_eng_tweet;

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
}

sleep(30);


print("Previsioni meteo e biometeo per domani tuittate");



?>