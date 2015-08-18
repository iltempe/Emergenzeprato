<?php

//Parser and tweeter per XML #pratopioggia
//by MT

// Include twitteroauth
require_once('twitteroauth.php');

// Set keys
$consumerKey = 'XjDBrc7Gson7nIr4zJtElMoBr';
$consumerSecret = 'SoHDr3rmAVuN5lBFmMGBMa6IJgwU3fRh1Ae8kiep2w0MWPoL32';
$accessToken = '2916596878-58ZHviCQS5iLn6ibv1G50VQJi7hXzAx9HHjdGmz';
$accessTokenSecret = 'HMk3SHn3G8Jn03R2v7bPJ8LzWnwbTcLTZDcWi3o048R9C';

date_default_timezone_set('UTC');
$today = date("Ymd");                           // data di oggi
print_r("Pratopioggia Rischi - Oggi è il ".$today);

//Gestione Rischio Regione Toscana
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks/".$today.".xml"); 

if ($sir_xml==false)
	{
	echo "Errore nella ricerca del file relativo al rischio";
	exit;
}else{

//In zona B2
$sir_str_1_1=("#cfr rischio #idrogeologico #allertameteoTOS #Prato (B2): " .$sir_xml->rischi->rischio[0]->area[5]->impatto);

$sir_str_2_1=("#cfr rischio #vento #allertameteoTOS #Prato (B2): " .$sir_xml->rischi->rischio[1]->area[5]->impatto);

$sir_str_3_1=("#cfr rischio #mareggiate #allertameteoTOS #Prato (B2): " .$sir_xml->rischi->rischio[2]->area[5]->impatto);

$sir_str_4_1=("#cfr rischio #neve #allertameteoTOS #Prato (B2): " .$sir_xml->rischi->rischio[3]->area[5]->impatto);

$sir_str_5_1=("#cfr rischio #ghiaccio #allertameteoTOS #Prato (B2): " .$sir_xml->rischi->rischio[4]->area[5]->impatto);

//In zona B3
$sir_str_1_2=("#cfr rischio #idrogeologico #allertameteoTOS #Prato #Carmignano #Montemurlo #PoggioaCaiano #Vaiano #Vernio (B3): " .$sir_xml->rischi->rischio[0]->area[6]->impatto);

$sir_str_2_2=("#cfr rischio #vento #allertameteoTOS #Prato #Carmignano #Montemurlo #PoggioaCaiano #Vaiano #Vernio (B3): " .$sir_xml->rischi->rischio[1]->area[6]->impatto);

$sir_str_3_2=("#cfr rischio #mareggiate #allertameteoTOS #Prato #Carmignano #Montemurlo #PoggioaCaiano #Vaiano #Vernio (B3): " .$sir_xml->rischi->rischio[2]->area[6]->impatto);

$sir_str_4_2=("#cfr rischio #neve #allertameteoTOS #Prato #Carmignano #Montemurlo #PoggioaCaiano #Vaiano #Vernio (B3): " .$sir_xml->rischi->rischio[3]->area[6]->impatto);

$sir_str_5_2=("#cfr rischio #ghiaccio #allertameteoTOS #Prato #Carmignano #Montemurlo #PoggioaCaiano #Vaiano #Vernio (B3): " .$sir_xml->rischi->rischio[4]->area[6]->impatto);

//In zona B5
$sir_str_1_3=("#cfr rischio #idrogeologico #allertameteoTOS #Vernio #Cantagallo (B5): " .$sir_xml->rischi->rischio[0]->area[8]->impatto);

$sir_str_2_3=("#cfr rischio #vento #allertameteoTOS #Vernio #Cantagallo (B5): " .$sir_xml->rischi->rischio[1]->area[8]->impatto);

$sir_str_3_3=("#cfr rischio #mareggiate #allertameteoTOS #Vernio #Cantagallo (B5): " .$sir_xml->rischi->rischio[2]->area[8]->impatto);

$sir_str_4_3=("#cfr rischio #neve #allertameteoTOS #Vernio #Cantagallo (B5): " .$sir_xml->rischi->rischio[3]->area[8]->impatto);

$sir_str_5_3=("#cfr rischio #ghiaccio #allertameteoTOS #Vernio #Cantagallo (B5): " .$sir_xml->rischi->rischio[4]->area[8]->impatto);

// Create object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

if($sir_xml->rischi->rischio[0]->area[5]->impatto != "nessuno")
{
	print_r($sir_str_1_1);
	// Set status message
	$tweetMessage = $sir_str_1_1;
	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[1]->area[5]->impatto != "nessuno")
{
	print_r($sir_str_2_1);
	// Set status message
	$tweetMessage = $sir_str_2_1;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[2]->area[5]->impatto != "nessuno")
{
	print_r($sir_str_3_1);
	// Set status message
	$tweetMessage = $sir_str_3_1;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[3]->area[5]->impatto != "nessuno")
{
	print_r($sir_str_4_1);
	// Set status message
	$tweetMessage = $sir_str_4_1;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}
	
if($sir_xml->rischi->rischio[4]->area[5]->impatto != "nessuno")
{
	print_r($sir_str_5_1);
	// Set status message
	$tweetMessage = $sir_str_5_1;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}
sleep(60);
	
	
if($sir_xml->rischi->rischio[0]->area[6]->impatto != "nessuno")
{
	print_r($sir_str_1_2);
	// Set status message
	$tweetMessage = $sir_str_1_2;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[1]->area[6]->impatto != "nessuno")
{
	print_r($sir_str_2_2);
	// Set status message
	$tweetMessage = $sir_str_2_2;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[2]->area[6]->impatto != "nessuno")
{
	print_r($sir_str_3_2);
	
	// Set status message
	$tweetMessage = $sir_str_3_2;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[3]->area[6]->impatto != "nessuno")
{
	print_r($sir_str_4_2);
	// Set status message
	$tweetMessage = $sir_str_4_2;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[4]->area[6]->impatto != "nessuno")
{
	print_r($sir_str_5_2);
	// Set status message
	$tweetMessage = $sir_str_5_2;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

sleep(60);

////
if($sir_xml->rischi->rischio[0]->area[8]->impatto != "nessuno")
{
	print_r($sir_str_1_3);
	// Set status message
	$tweetMessage = $sir_str_1_3;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[1]->area[8]->impatto != "nessuno")
{
	print_r($sir_str_2_3);
	// Set status message
	$tweetMessage = $sir_str_2_3;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}
if($sir_xml->rischi->rischio[2]->area[8]->impatto != "nessuno")
{
	print_r($sir_str_3_3);

	// Set status message
	$tweetMessage = $sir_str_3_3;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}
	
if($sir_xml->rischi->rischio[3]->area[8]->impatto != "nessuno")
{
	print_r($sir_str_4_3);

	// Set status message
	$tweetMessage = $sir_str_4_3;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[4]->area[8]->impatto != "nessuno")
{
	print_r($sir_str_5_3);

	// Set status message
	$tweetMessage = $sir_str_5_3;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}
}

//Fonti
//http://www.sir.toscana.it/supports/xml/risks/20141202.xml

?>