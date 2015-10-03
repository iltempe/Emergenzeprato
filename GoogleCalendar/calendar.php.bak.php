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

    // For loging out.
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

	//selezionare cosa postare sul calendario
	
	if($_GET["what"]=="meteo_oggi")
	{
		//prepara evento meteo
		$event_data_meteo=prepare_event_meteo_oggi($data);
		$event = new Google_Service_Calendar_Event($event_data_meteo); 
	
		//invia evento meteo
		$calendarId = 'primary';
		$event = $service->events->insert($calendarId, $event);
	}
	elseif($_GET["what"]=="meteo_domani")
	{
		//prepara evento
		$event_data_meteo=prepare_event_meteo_domani($data);
		$event = new Google_Service_Calendar_Event($event_data_meteo); 
	
		//invia evento
		$calendarId = 'primary';
		$event = $service->events->insert($calendarId, $event);
	
	}elseif($_GET["what"]=="rischio")
	{
		//prepara evento
		$event_data_meteo=prepare_event_meteo_rischi($data);
		$event = new Google_Service_Calendar_Event($event_data_meteo); 
	
		//invia evento meteo
		$calendarId = 'primary';
		$event = $service->events->insert($calendarId, $event);
	
	}
	else{
	
	//do nothing
	}


	while(true) {
		 foreach ($calendarList->getItems() as $calendarListEntry) {

			// echo $calendarListEntry->getSummary()."<br>\n";

			 $events = $service->events->listEvents($calendarListEntry->id);


			 foreach ($events->getItems() as $event) {
			     echo "-----".$event->getSummary()."<br>";
			 }
		 }
		 $pageToken = $calendarList->getNextPageToken();
		 if ($pageToken) {
			 $optParams = array('pageToken' => $pageToken);
			 $calendarList = $service->calendarList->listCalendarList($optParams);
		 } else {
			 break;
		 }
	 }
    }
    
	//prepara l'evento meteo di oggi
    function prepare_event_meteo_oggi($data)
    {
		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
		
		echo date(DATE_RFC3339);
		
		$testo=$data->lamma_text("oggi");
		
		$event_data=array(
		  'summary' => $testo,
		  'location' => 'Prato',
		  'description' => $testo. " " .$data->biometeo_ita_text("oggi").' Servizio sperimentale Emergenzeprato, fonti e crediti su https://iltempe.github.io/Emergenzeprato/',
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
		  'summary' => "Previsioni per domani: ".$testo,
		  'location' => 'Prato',
		  'description' => $testo. " " .$data->biometeo_ita_text("domani").' Servizio sperimentale Emergenzeprato, fonti e crediti su https://iltempe.github.io/Emergenzeprato/',
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
    
    //prepara l'evento meteo di previsioni rischio oggi e domani
    function prepare_event_meteo_rischi($data)
    {
		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d");
		
		$rischio_oggi="Rischi di oggi \r\n". $data->risk_text("oggi","B").$data->risk_text("oggi","R1");
		$rischio_domani= "Rischi di domani \r\n". $data->risk_text("domani","B").$data->risk_text("domani","R1");

		$event_data=array(
		  'summary' => "Rischi Idrogeologici oggi/domani",
		  'location' => 'Prato',
		  'description' => $rischio_oggi. $rischio_domani.'Servizio sperimentale Emergenzeprato, fonti e crediti su https://iltempe.github.io/Emergenzeprato/',
		  'start' => array(
			//'dateTime' => date(DATE_RFC3339),
			'date' => $today,
			'timeZone' => 'Europe/Rome',
		  ),
		   'end' => array(
			 'date' => $today,
			 //'dateTime' => date(DATE_RFC3339, strtotime('+1 hours')),
			 'timeZone' => 'Europe/Rome',
		   ),
		  );
		  
		  return $event_data;
    }
    
?>