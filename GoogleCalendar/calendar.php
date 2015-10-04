<?php    
    require_once 'Google/autoload.php';
    require_once '../getting.php';
    
    // ********************************************************  //
    // Get these values from https://console.developers.google.com
    // Be sure to enable the Analytics API
    // ********************************************************    //

    //nome applicazione da autorizzare
    define('APPLICATION_NAME', 'emergenzeprato');
    //file scaricato da consol google dev.
	define('CLIENT_SECRET_PATH', 'client_secret.json');
	
	define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR)
));
        
	//data getter
	$data=new getdata();
	
	//client per calendario
    $client=getClient(); 
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
	
	


 //Returns an authorized API client.
 //@return Google_Client the authorized client object

function getClient() {

    //credenziali memorizzate
  define('CREDENTIALS_PATH', 'credential.json');
  unlink('credential.json');
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');
  $client->setApprovalPrompt('force');
   
 // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = file_get_contents($credentialsPath);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->authenticate($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, $accessToken);
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
  	$new=$client->getRefreshToken();
    $client->refreshToken($new);
    file_put_contents($credentialsPath, $client->getAccessToken());
  }
  return $client;
}


  //Expands the home directory alias '~' to the full path.
 //@param string $path the path to expand.
 //@return string the expanded path.
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
  }
  return str_replace('~', realpath($homeDirectory), $path);
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