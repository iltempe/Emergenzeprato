<?php

//Parser and tweeter per XML #pratopioggia
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
print_r("Oggi è il ".$today);

//Gestione Rischio Regione Toscana
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks/".$today.".xml"); 
echo "http://www.sir.toscana.it/supports/xml/risks/".$today.".xml";

if ($sir_xml==false)
	{
	echo "Errore nella ricerca del file relativo al rischio";
	exit;
}else{

//In zona B2
$sir_str_1_1=("Rischio idrogeologico-idraulico Comune di Prato (B2): " .$sir_xml->rischi->rischio[0]->area[5]->impatto);
print_r($sir_str_1_1);

$sir_str_2_1=("Rischio vento Comune di Prato (B2): " .$sir_xml->rischi->rischio[1]->area[5]->impatto);
print_r($sir_str_2_1);

$sir_str_3_1=("Rischio mareggiate Comune di Prato (B2): " .$sir_xml->rischi->rischio[2]->area[5]->impatto);
print_r($sir_str_3_1);

$sir_str_4_1=("Rischio neve Comune di Prato (B2): " .$sir_xml->rischi->rischio[3]->area[5]->impatto);
print_r($sir_str_4_1);

$sir_str_5_1=("Rischio ghiaccio Comune di Prato (B2): " .$sir_xml->rischi->rischio[4]->area[5]->impatto);
print_r($sir_str_5_1);

//In zona B3
$sir_str_1_2=("Rischio idrogeologico-idraulico Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[0]->area[6]->impatto);
print_r($sir_str_1_2);

$sir_str_2_2=("Rischio vento Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[1]->area[6]->impatto);
print_r($sir_str_2_2);

$sir_str_3_2=("Rischio mareggiate Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[2]->area[6]->impatto);
print_r($sir_str_3_2);

$sir_str_4_2=("Rischio neve Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[3]->area[6]->impatto);
print_r($sir_str_4_2);

$sir_str_5_2=("Rischio ghiaccio Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[4]->area[6]->impatto);
print_r($sir_str_5_2);

//In zona B5
$sir_str_1_3=("Rischio idrogeologico-idraulico Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[0]->area[8]->impatto);
print_r($sir_str_1_3);

$sir_str_2_3=("Rischio vento Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[1]->area[8]->impatto);
print_r($sir_str_2_3);

$sir_str_3_3=("Rischio mareggiate Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[2]->area[8]->impatto);
print_r($sir_str_3_3);

$sir_str_4_3=("Rischio neve Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[3]->area[8]->impatto);
print_r($sir_str_4_3);

$sir_str_5_3=("Rischio ghiaccio Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[4]->area[8]->impatto);
print_r($sir_str_5_3);


// Create object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

if($sir_xml->rischi->rischio[0]->area[5]->impatto != "nessuno")
{
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