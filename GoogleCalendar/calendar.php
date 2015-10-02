<?php    
    require_once 'Google/autoload.php';
    require_once 'settings.php';
    require_once '../getting.php';
    
    session_start(); 

    // ********************************************************  //
    // Get these values from https://console.developers.google.com
    // Be sure to enable the Analytics API
    // ********************************************************    //
    
    
    $client_id = GOOGLECAL_CLIENT_ID;
    $client_secret = GOOGLECAL_CLIENT_SECRET;
    $redirect_uri = GOOGLECAL_REDIRECT_URI;

    $client = new Google_Client();
    $client->setApplicationName("emergenzeprato");
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->setAccessType('offline');   // Gets us our refreshtoken
    $client->setScopes(array('https://www.googleapis.com/auth/calendar'));
	
	//data getter
	$data=new getdata();

    //For loging out.
    if (isset($_GET['logout'])) {
	unset($_SESSION['token']);
    }


    // Step 2: The user accepted your access now you need to exchange it.
    if (isset($_GET['code'])) {
	
	$client->authenticate($_GET['code']);  
	$_SESSION['token'] = $client->getAccessToken();
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    }

    // Step 1:  The user has not authenticated we give them a link to login    
    if (!isset($_SESSION['token'])) {

	$authUrl = $client->createAuthUrl();

	print "<a class='login' href='$authUrl'>Connect Me!</a>";
    }    

    // Step 3: We have access we can now create our service
    if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
	print "<a class='logout' ". $redirect_uri. "?logout=1'>LogOut</a><br>";	
	
	$service = new Google_Service_Calendar($client);    
	
	$calendarList  = $service->calendarList->listCalendarList();

	//prepara evento meteo
	$event_data_meteo=prepare_event_meteo_oggi($data);
	$event = new Google_Service_Calendar_Event($event_data_meteo); 
	
	//invia evento meteo
	$calendarId = 'primary';
	$event = $service->events->insert($calendarId, $event);

	//prepara evento meteo 2
	$event_data_meteo=prepare_event_meteo_domani($data);
	$event = new Google_Service_Calendar_Event($event_data_meteo); 
	
	//invia evento meteo
	$calendarId = 'primary';
	$event = $service->events->insert($calendarId, $event);
	

	// while(true) {
		// foreach ($calendarList->getItems() as $calendarListEntry) {

			// echo $calendarListEntry->getSummary()."<br>\n";


			// $events = $service->events->listEvents($calendarListEntry->id);


			// foreach ($events->getItems() as $event) {
			    // echo "-----".$event->getSummary()."<br>";
			// }
		// }
		// $pageToken = $calendarList->getNextPageToken();
		// if ($pageToken) {
			// $optParams = array('pageToken' => $pageToken);
			// $calendarList = $service->calendarList->listCalendarList($optParams);
		// } else {
			// break;
		// }
	// }
    }
    
	//prepara l'evento meteo di oggi
    function prepare_event_meteo_oggi($data)
    {
		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
		
		echo date(DATE_RFC3339);
		
		$data->lamma_text("oggi");
		//$data->lamma_text("domani");
		
		//$data->risk_text("domani","B");
		//$data->risk_text("domani","R1");
		//$inizio=date(DATE_RFC3339);
		
		$event_data=array(
		  'summary' => $data->lamma_text("oggi"),
		  'location' => 'Prato',
		  'description' => 'dati forniti da http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml',
		  'start' => array(
			'dateTime' => date(DATE_RFC3339),
			'timeZone' => 'Europe/Rome',
		  ),
		   'end' => array(
			 'dateTime' => date(DATE_RFC3339, strtotime('+4 hours')),
			 'timeZone' => 'Europe/Rome',
		   ),
		  );
		  
		  return $event_data;
    }
	
	//prepara l'evento meteo di previsioni domani
    function prepare_event_meteo_domani($data)
    {
		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
				
		$testo=$data->lamma_text("domani");
		
		//$data->risk_text("domani","B");
		//$data->risk_text("domani","R1");
		
		$event_data=array(
		  'summary' => "Previsione meteo per domani: ".$testo,
		  'location' => 'Prato',
		  'description' => 'dati forniti da http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml',
		  'start' => array(
			'dateTime' => date(DATE_RFC3339, strtotime('+10 hours')),
			'timeZone' => 'Europe/Rome',
		  ),
		   'end' => array(
			 'dateTime' => date(DATE_RFC3339, strtotime('+14 hours')),
			 'timeZone' => 'Europe/Rome',
		   ),
		  );
		  
		  return $event_data;
    }
    
?>