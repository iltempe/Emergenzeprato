<?php

//Tweet previsioni rischio di oggi o domani
//da chiamare da TwitterBot folder ad esempio in questo modo
// php /Users/TeoPro/Documents/git/xml_parser/TwitterBot/tweet_risk.php "domani";
//by MT

include(dirname(__FILE__).'/../settings.php');
include(dirname(__FILE__).'/../getting.php');

// Include twitteroauth
require_once('twitteroauth.php');

$logfile=(dirname(__FILE__).'/../log/twitter.log');


//esegue la funzione
$when=$argv[1];
$data=new getdata();
tweet_risk($when, $data);

//log
$log=$today ";" $xmlFile." eseguito tweet rischi\n";
file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);


function tweet_risk($when, $data)
{

	// Set keys
	$consumerKey = CONSUMER_KEY;
	$consumerSecret = CONSUMER_SECRET;
	$accessToken = ACCESS_TOKEN;
	$accessTokenSecret = ACCESS_TOKEN_SECRET;

	//In zona B
	$sir_str_1_1=("#cfr " .$when. " rischio #idrogeologico #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","idrogeologico"));

	$sir_str_2_1=("#cfr " .$when. " rischio #idraulico #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","idraulico"));

	$sir_str_3_1=("#cfr " .$when. " rischio #vento #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","vento"));

	$sir_str_4_1=("#cfr " .$when. " rischio #mareggiate #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","mareggiate"));

	$sir_str_5_1=("#cfr " .$when. " rischio #neve #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","neve"));

	$sir_str_6_1=("#cfr " .$when. " rischio #ghiaccio #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","ghiaccio"));
	
	$sir_str_7_1=("#cfr " .$when. " rischio #temporali #allertameteoTOS #Prato : " .$data->select_risk_data($when, "B","temporali"));

	//In zona R1
	$sir_str_1_2=("#cfr " .$when. " rischio #idrogeologico #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","idrogeologico"));

	$sir_str_2_2=("#cfr " .$when. " rischio #idraulico #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","idraulico"));

	$sir_str_3_2=("#cfr " .$when. " rischio #vento #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","vento"));

	$sir_str_4_2=("#cfr " .$when. " rischio #mareggiate #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","mareggiate"));

	$sir_str_5_2=("#cfr " .$when. " rischio #neve #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","neve"));

	$sir_str_6_2=("#cfr " .$when. " rischio #ghiaccio #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","ghiaccio"));
	
	$sir_str_7_2=("#cfr " .$when. " rischio #temporali #allertameteoTOS #Vernio : " .$data->select_risk_data($when, "R1","temporali"));

	// Create object
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

	if($data->select_risk_data($when, "B","idrogeologico") != "nessuno" && $data->select_risk_data($when, "B","idrogeologico") != "")
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

	if($data->select_risk_data($when, "B","idraulico") != "nessuno" && $data->select_risk_data($when, "B","idraulico") != "")
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
	
	if($data->select_risk_data($when, "B","vento") != "nessuno" && $data->select_risk_data($when, "B","vento") != "")
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

	if($data->select_risk_data($when, "B","mareggiate") != "nessuno" && $data->select_risk_data($when, "B","mareggiate") != "")
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

	if($data->select_risk_data($when, "B","neve") != "nessuno" && $data->select_risk_data($when, "B","neve") != "")
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
	
	if($data->select_risk_data($when, "B","ghiaccio") != "nessuno" && $data->select_risk_data($when, "B","ghiaccio") != "")
	{
		// Set status message
		$tweetMessage = $sir_str_6_1;

		// Check for 140 characters
		if(strlen($tweetMessage) <= 140)
		{
			// Post the status message
			$tweet->post('statuses/update', array('status' => $tweetMessage));
		}
	}

	if($data->select_risk_data($when, "B","temporali") != "nessuno" && $data->select_risk_data($when, "B","temporali") != "")
	{
		// Set status message
		$tweetMessage = $sir_str_7_1;

		// Check for 140 characters
		if(strlen($tweetMessage) <= 140)
		{
			// Post the status message
			$tweet->post('statuses/update', array('status' => $tweetMessage));
		}
	}
	
	sleep(60);
	
	if($data->select_risk_data($when, "R1","idrogeologico") != "nessuno" && $data->select_risk_data($when, "R1","idrogeologico") != "")
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

	if($data->select_risk_data($when, "R1","idraulico") != "nessuno" && $data->select_risk_data($when, "R1","idraulico") != "")
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
	if($data->select_risk_data($when, "R1","vento") != "nessuno" && $data->select_risk_data($when, "R1","vento") != "")
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

	if($data->select_risk_data($when, "R1","mareggiate") != "nessuno" && $data->select_risk_data($when, "R1","mareggiate") != "")
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

	if($data->select_risk_data($when, "R1","neve") != "nessuno" && $data->select_risk_data($when, "R1","neve") != "")
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
	
	if($data->select_risk_data($when, "R1","ghiaccio") != "nessuno" && $data->select_risk_data($when, "R1","ghiaccio") != "")
	{
		// Set status message
		$tweetMessage = $sir_str_6_2;

		// Check for 140 characters
		if(strlen($tweetMessage) <= 140)
		{
			// Post the status message
			$tweet->post('statuses/update', array('status' => $tweetMessage));
		}
	}

	if($data->select_risk_data($when, "R1","temporali") != "nessuno" && $data->select_risk_data($when, "R1","temporali") != "")
	{
		// Set status message
		$tweetMessage = $sir_str_7_2;

		// Check for 140 characters
		if(strlen($tweetMessage) <= 140)
		{
			// Post the status message
			$tweet->post('statuses/update', array('status' => $tweetMessage));
		}
	}
	

}

?>