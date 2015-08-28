<?php

//Parser and tweeter per XML #pratopioggia
//by MT

include(dirname(__FILE__).'/../settings.php');
include(dirname(__FILE__).'/../getdata.php');

// Include twitteroauth
require_once('twitteroauth.php');

// Set keys
$consumerKey = CONSURMER_KEY;
$consumerSecret = CONSUMER_SECRET;
$accessToken = ACCESS_TOKEN;
$accessTokenSecret = ACCESS_TOKEN_SECRET;

date_default_timezone_set('UTC');
$today = date("Ymd");                           // data di oggi
print_r("Oggi è il ".$today);

//biometeo
$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");
$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");

//lamma opentoscana
$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//XML data parsing for @pratopioggia
$lamma_str=("Previsioni #meteo #Lamma #prato: " .$lamma_xml->previsione[0]->simbolo[descr]." Temperature min " .$lamma_xml->previsione[0]->temp[0]. " max " .$lamma_xml->previsione[0]->temp[1]);

$biometeo_ita_str=("Previsioni #Biometeo #prato: mat " .$biometeo_ita_xml->localita->AA_des_m_oggi. " pom " .$biometeo_ita_xml->localita->AA_des_p_oggi. " sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);
$biometeo_eng_str=("Forecast #Biometeo #prato: mor " .$biometeo_eng_xml->localita->AA_des_m_oggi. " aft " .$biometeo_eng_xml->localita->AA_des_p_oggi. " eve " .$biometeo_eng_xml->localita->AA_des_s_oggi);

// Create object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// Set status message
$tweetMessage = $lamma_str;

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
}

sleep(60);

// Set status message
$tweetMessage = $biometeo_ita_str;

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
}

sleep(60);

// Set status message
$tweetMessage = $biometeo_eng_str;

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
}

sleep(60);

//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml

?>