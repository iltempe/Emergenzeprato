<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */

include(dirname(__FILE__).'/../settings.php');
include('settings_t.php');
include("emergenzeprato.php");


	date_default_timezone_set('Europe/Rome');
	$today = date("Y-m-d H:i:s"); 
	
	$db = new PDO(DB_NAME);

	$data=new getdata();

	$update_manager= new emergenzeprato();
	
	//istanzia oggetto Telegram
	$bot_id = TELEGRAM_BOT;
	$bot = new Telegram($bot_id);
	
	//inizializzo il bot
	$bot->init();
	
	//gestore broadcast
	broadcast_manager($db,$bot,$data);
		

?>
