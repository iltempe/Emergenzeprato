<?php

//tweeter per temperature @pratopioggia
//by MT

include(dirname(__FILE__).'/../settings.php');
include(dirname(__FILE__).'/../getting.php');

// Include twitteroauth
require_once('twitteroauth.php');

//esegue la funzione
$data=new getdata();
tweet_temperature("prato est", $data);
sleep(60);
tweet_temperature("carmignano", $data);
sleep(60);
tweet_temperature("vaiano sofignano", $data);
sleep(60);
tweet_temperature("vaiano schignano", $data);
sleep(60);
tweet_temperature("montepiano vernio", $data);

print_r("eseguito tweet_temperatura");


function tweet_temperature($where, $data)
{

	// Set keys
	$consumerKey = CONSUMER_KEY;
	$consumerSecret = CONSUMER_SECRET;
	$accessToken = ACCESS_TOKEN;
	$accessTokenSecret = ACCESS_TOKEN_SECRET;

	// Create object
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

	//tweet temperatura
	$temp=$data->get_temperature($where);
	$tweetMessage=("Temperatura attuale misurata in zona " .$where. " : " .$temp);
	$tweet->post('statuses/update', array('status' => $tweetMessage));
	print($tweetMessage);

}

?>