<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */

include(dirname(__FILE__).'/../settings.php');
include('settings_t.php');
include(dirname(dirname(__FILE__)).'/getting.php');
include("emergenzeprato.php");

	date_default_timezone_set('Europe/Rome');
	$today = date("Y-m-d H:i:s"); 
	
	$db = new PDO(DB_NAME);

	$data=new getdata();

	$update_manager= new emergenzeprato();
	
	//gestore broadcast
	broadcast_manager($db,$bot,$data);
	
	//gestore broadcast
	//commentare in modalita DEBUG per evitare invio messaggi agli utenti!
	broadcast_manager($db,$telegram,$data);
		

?>
