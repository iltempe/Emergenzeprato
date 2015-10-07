#!/usr/bin/php

<?php

//main file to define and send alert
//to be managed as CRON JOB to send alert 
//NOT USED YET

require_once __DIR__.'/./settings.php';
require_once __DIR__.'/./TelegramBot/broadcast_sender.php';
require_once __DIR__.'/./TwitterBot/tweet_something.php';


// file di appoggio per i dati
$file = dirname(__FILE__).'/data/protezione_civile.txt';

//preparo il getter
$data= new getdata();

//prelevo il dato attuale dal sito
$current=$data->getting_actual_website_prot();

//stampo il file (la prima volta)
if(!file_exists($file))
{
	file_put_contents($file, $current);
}
else{
	
	//se il file esiste già fare il confronto
	$old=file_get_contents($file);
	if($old!=$current)
	{
		send_alert($current);
		file_put_contents($file, $current);
	}
	else
	{
		//se non ci sono aggiornamenti non fare nulla
	}
}

function send_alert($current)
{
	//inserire cosa fare in caso di invio allerta
	print_r("invio allerta");
	//TELEGRAM BROADCAST
	broadcast_go($current);
	
	//TWEET
	tweet_something($current,"..aggiornamento da #protezionecivile di #prato goo.gl/2wwPts #allertameteoTOS");
}


			
?>