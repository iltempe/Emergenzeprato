<?php

//tweeter per temperature @pratopioggia
//by MT

include('settings.php');
include(dirname(__FILE__).'/../getting.php');

// Include twitteroauth
require_once('TwitterOAuth.php');

$logfile=(dirname(__FILE__).'/../logs/twitter.log');
date_default_timezone_set('Europe/Rome');
$today = date("Y-m-d H:i:s");

//esegue la funzione
$data=new getdata();

tweet_pics("IDROMETRIA_Bisenzio_Prato", $data);
/*sleep(TWEET_PAUSE);
tweet_pics("IDROMETRIA_Bisenzio_Vaiano_Gamberame", $data);
sleep(TWEET_PAUSE);
tweet_pics("IDROMETRIA_Ombrone_PonteAlleVanne", $data);
sleep(TWEET_PAUSE);
tweet_pics("IDROMETRIA_Ombrone_PoggioACaiano", $data);
sleep(TWEET_PAUSE);

tweet_pics("PLUVIOMETRIA_Prato_Città", $data);
sleep(TWEET_PAUSE);
tweet_pics("PLUVIOMETRIA_Prato_Università", $data);
sleep(TWEET_PAUSE);
tweet_pics("PLUVIOMETRIA_Galceti_Montemurlo", $data);
sleep(TWEET_PAUSE);
tweet_pics("PLUVIOMETRIA_Vaiano_Gamberame", $data);
sleep(TWEET_PAUSE);
tweet_pics("PLUVIOMETRIA_Vaiano_Acquedotto", $data);
sleep(TWEET_PAUSE);
tweet_pics("PLUVIOMETRIA_Fattoria_Iavello_Montemurlo", $data);
sleep(TWEET_PAUSE);
tweet_pics("PLUVIOMETRIA_Cantagallo", $data);

sleep(TWEET_PAUSE);
tweet_pics("TERMOMETRIA_Prato_Università", $data);
sleep(TWEET_PAUSE);
tweet_pics("TERMOMETRIA_Galceti_Montemurlo", $data);

sleep(TWEET_PAUSE);
tweet_pics("ANEMOMETRIA_Prato_Università", $data);
sleep(TWEET_PAUSE);
tweet_pics("ANEMOMETRIA_Galceti_Montemurlo", $data);

sleep(TWEET_PAUSE);
tweet_pics("IGROMETRIA_Prato_Città", $data);
sleep(TWEET_PAUSE);
tweet_pics("IGROMETRIA_Galceti_Montemurlo", $data);
sleep(TWEET_PAUSE);
tweet_pics("IGROMETRIA_Vaiano_Acquedotto", $data);*/

//log
$log=$today. ";" .$xmlFile." eseguito tweet immagini\n";
file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);

//funzione che tuitta immagini a partire dal nome
function tweet_pics($what, $data)
{

	// Set keys
	$consumerKey = CONSUMER_KEY;
	$consumerSecret = CONSUMER_SECRET;
	$accessToken = ACCESS_TOKEN;
	$accessTokenSecret = ACCESS_TOKEN_SECRET;

	// Create object
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

	//tweet image
	$text="#cfr #toscana http://www.cfr.toscana.it/ ". str_replace("_"," #",$what);
	$img_path=(dirname(dirname(__FILE__)). "/". $data->get_image_path($what));
	
	$media = $tweet->upload('media/upload', array('media' => $img_path));
	$params = array(
    'status' => $text,
    'media_ids' => $media->media_id_string,
	);
	
	$response = $tweet->post('statuses/update', $params);
	print_r($response);
}

?>