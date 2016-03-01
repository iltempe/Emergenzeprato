#!/usr/bin/php

<?php

//Tweet previsioni per meteo e biometeo di oggi o domani
//da chiamare da TwitterBot folder ad esempio in questo modo
// php /Users/TeoPro/Documents/git/xml_parser/TwitterBot/tweet_meteo.php "domani";
//by MT


include('settings.php');
include(dirname(__FILE__).'/../getting.php');

// Include twitteroauth
require_once('twitteroauth.php');

$logfile=(dirname(__FILE__).'/../logs/twitter.log');
$xmlFile=(dirname(__FILE__).'/../data/meteo.xml');

date_default_timezone_set('Europe/Rome');
$today = date("Y-m-d H:i:s");

//esegue la funzione
$when=$argv[1];

$data=new getdata();

tweet_meteo($when, $data);

//log
$log=$today. ";" .$xmlFile." eseguito tweet meteo\n";
file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);

//prepara i tweet e li invia a distanza di 35 secondi circa
function tweet_meteo($when="oggi", $data)
{
	// Set keys
	$consumerKey = CONSUMER_KEY;
	$consumerSecret = CONSUMER_SECRET;
	$accessToken = ACCESS_TOKEN;
	$accessTokenSecret = ACCESS_TOKEN_SECRET;
	
	$meteo_tweet_text="Previsioni #meteo #Lamma #prato per ". strval($when). " ";
	$biometeo_tweet_text="Previsioni #biometeo #Lamma #prato per ". strval($when). " ";


	$lamma_tweet=($meteo_tweet_text. $data->lamma_text($when));
	$biometeo_ita_tweet=($biometeo_tweet_text. $data->lamma_text($when));
	
	if($when=="domani")
	{
		$biometeo_eng_tweet=("Forecast tomorrow #Biometeo #prato: " .$data->biometeo_eng_text($when));
	}
	else
	{
		$biometeo_eng_tweet=("Forecast today #Biometeo #prato: " .$data->biometeo_eng_text($when));
	}

	// Create object
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
	
	$tweetMessage = $lamma_tweet;
	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{

		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}

	sleep(TWEET_PAUSE);

	// Set status message
	$tweetMessage = $biometeo_ita_tweet;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}

	sleep(TWEET_PAUSE);

	// Set status message
	$tweetMessage = $biometeo_eng_tweet;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}


}



?>