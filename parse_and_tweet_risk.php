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
print_r("EmergenzePrato Rischi - Oggi è il ".$today);

//Gestione Rischio Regione Toscana
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"); 

if ($sir_xml==false)
	{
	print_r("Errore nella ricerca del file relativo al rischio");
	exit;
}else{


//In zona B
$sir_str_1_1=("#cfr rischio #idrogeologico #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[0]->area[7]->impatto);

$sir_str_2_1_1=("#cfr rischio #idraulico #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[1]->area[7]->impatto);

$sir_str_2_1=("#cfr rischio #vento #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[2]->area[7]->impatto);

$sir_str_3_1=("#cfr rischio #mareggiate #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[3]->area[7]->impatto);

$sir_str_4_1=("#cfr rischio #neve #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[4]->area[7]->impatto);

$sir_str_5_1=("#cfr rischio #ghiaccio #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[5]->area[7]->impatto);
	
$sir_str_5_1_1=("#cfr rischio #temporali #allertameteoTOS #Prato (B): " .$sir_xml->rischi->rischio[6]->area[7]->impatto);

//In zona R1
$sir_str_1_2=("#cfr rischio #idrogeologico #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[0]->area[19]->impatto);

$sir_str_2_1_2=("#cfr rischio #idraulico #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[1]->area[19]->impatto);

$sir_str_2_2=("#cfr rischio #vento #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[2]->area[19]->impatto);

$sir_str_3_2=("#cfr rischio #mareggiate #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[3]->area[19]->impatto);

$sir_str_4_2=("#cfr rischio #neve #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[4]->area[19]->impatto);

$sir_str_5_2=("#cfr rischio #ghiaccio #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[5]->area[19]->impatto);
	
$sir_str_5_1_2=("#cfr rischio #temporali #allertameteoTOS #Vernio (R1): " .$sir_xml->rischi->rischio[6]->area[19]->impatto);


// Create object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

if($sir_xml->rischi->rischio[0]->area[7]->impatto != "nessuno")
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

if($sir_xml->rischi->rischio[1]->area[7]->impatto != "nessuno")
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
	if($sir_xml->rischi->rischio[2]->area[7]->impatto != "nessuno")
{
	print_r($sir_str_2_1_1);
	// Set status message
	$tweetMessage = $sir_str_2_1_1;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[3]->area[7]->impatto != "nessuno")
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

if($sir_xml->rischi->rischio[4]->area[7]->impatto != "nessuno")
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
	
if($sir_xml->rischi->rischio[5]->area[7]->impatto != "nessuno")
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

	if($sir_xml->rischi->rischio[6]->area[7]->impatto != "nessuno")
{
	print_r($sir_str_5_1_1);
	// Set status message
	$tweetMessage = $sir_str_5_1_1;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}
	
sleep(60);
	
if($sir_xml->rischi->rischio[0]->area[19]->impatto != "nessuno")
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

if($sir_xml->rischi->rischio[1]->area[19]->impatto != "nessuno")
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
	if($sir_xml->rischi->rischio[2]->area[19]->impatto != "nessuno")
{
	print_r($sir_str_2_1_2);
	// Set status message
	$tweetMessage = $sir_str_2_1_2;

	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
		// Post the status message
		$tweet->post('statuses/update', array('status' => $tweetMessage));
	}
}

if($sir_xml->rischi->rischio[3]->area[19]->impatto != "nessuno")
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

if($sir_xml->rischi->rischio[4]->area[19]->impatto != "nessuno")
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
	
if($sir_xml->rischi->rischio[5]->area[19]->impatto != "nessuno")
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

	if($sir_xml->rischi->rischio[6]->area[19]->impatto != "nessuno")
{
	print_r($sir_str_5_1_2);
	// Set status message
	$tweetMessage = $sir_str_5_1_2;

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
//http://www.sir.toscana.it/supports/xml/risks_395/20150818.xml

?>