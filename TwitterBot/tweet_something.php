<?php

//tweeter per temperature @emergenzeprato
//by MT

require_once __DIR__.'/./settings.php';
require_once('twitteroauth.php');

function tweet_something($data, $append)
{
	$logfile=(dirname(__FILE__).'/../logs/twitter.log');
	date_default_timezone_set('Europe/Rome');
	$today = date("Y-m-d H:i:s");

	//log
	$log=$today. ";eseguito tweet temperature\n";
	file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);

	// Set keys
	$consumerKey = CONSUMER_KEY;
	$consumerSecret = CONSUMER_SECRET;
	$accessToken = ACCESS_TOKEN;
	$accessTokenSecret = ACCESS_TOKEN_SECRET;

	// Create object
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

	//tweet qualcosa
	$tweetMessage=limit_text_tweet($data,55,$append);
	$tweet->post('statuses/update', array('status' => $tweetMessage));
    print_r($tweetMessage);

}

function limit_text_tweet($text, $limit, $append) {
   
	if(strlen($text) > $limit)
	{
     $text = substr($text,0,$limit);
    }
    
    return $text. $append;
}

?>