#!/usr/bin/php

<?php

//main file to define and send alert
//to be managed as CRON JOB to send alert 
//NOT USED YET

require_once __DIR__.'/./settings.php';
require_once __DIR__.'/./TelegramBot/broadcast_sender.php';
require_once __DIR__.'/./TwitterBot/tweet_something.php';
require_once __DIR__.'/./GroupMeBot/bot.php';


// file di appoggio per i dati
$file = dirname(__FILE__).'/data/protezione_civile.txt';

//preparo il getter
$data= new getdata();

//prelevo il dato attuale dal sito
$current=$data->getting_actual_website_prot();


//stampo il file protezione civile(la prima volta)
if(!file_exists($file))
{
	file_put_contents($file, $current[0]);
}
else{
	
	//se il file esiste già fare il confronto
	$old=file_get_contents($file);

	if($old!=$current[0])
	{
		send_alert($current);
		file_put_contents($file, $current[0]);
	}
	else
	{
		//se non ci sono aggiornamenti non fare nulla
	}
}

//function to send alert bomb!
//current[0] long data
//current[1] short data
function send_alert($current)
{
	//inserire cosa fare in caso di invio allerta
	print_r("invio allerta");
	

	if($current[0]!="")
	{
		//TELEGRAM BROADCAST
		broadcast_go($current[0]);
	}
	
	if($current[1]!="")
	{
		//TWEET
		tweet_something($current[1],"..aggiornamento #protezionecivile #prato goo.gl/2wwPts #allertameteoTOS");
		//print_r($current[1]);
		
		sleep(30);
		
		//GROUPME
		groupme_send($current[1]. "..aggiornamento #protezionecivile #prato goo.gl/2wwPts #allertameteoTOS");
	}
}


			
?>
