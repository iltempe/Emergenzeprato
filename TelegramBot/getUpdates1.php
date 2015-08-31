#!/usr/bin/php

<?php
/**
 * Telegram Bot Example whitout WebHook.
 * It uses getUpdates Telegram's API.
 * designed starting from https://github.com/Eleirbag89/TelegramBotPHP
 
 Done! Congratulations on your new bot. 
 You will find it at telegram.me/emergenzeprato_bot. 
 You can now add a description, about section and profile picture for your bot, see /help for a list of commands.

Use this token to access the HTTP API:

For a description of the Bot API, see this page: https://core.telegram.org/bots/api
 */

include(dirname(__FILE__).'/../settings.php');
include(dirname(__FILE__).'/../getting.php');
include("Telegram.php");

//per gestione segnalazione
include(dirname(__FILE__).'/GeoJSON/vendor/autoload.php');
use GeoJSON\FeatureCollection;
use GeoJSON\Feature;
use GeoJSON\Point;
use GeoJSON\MultiPoint;


date_default_timezone_set('Europe/Rome');
$today = date("Y-m-d H:i:s"); 

$bot_id = TELEGRAM_BOT ;
$telegram = new Telegram($bot_id);
$data=new getdata();

$logfile=(dirname(__FILE__).'/../log/telegram.log');

// Get all the new updates and set the new correct update_id
$req = $telegram->getUpdates();
print_r($req[1]);
for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
	// You NEED to call serveUpdate before accessing the values of message in Telegram Class
	$telegram->serveUpdate($i);
	$text = $telegram->Text();
	$chat_id = $telegram->ChatID();

	if ($text == "/start") {
		 $option = array(["meteo","previsioni"],["rischi", "temperatura"],["crediti"]);
    	// Crea la tastiera
    	$keyb = $telegram->buildKeyBoard($option, $onetime=false);
    	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Benvenuto in emergenzeprato, seleziona una opzione per essere aggiornato");
		$telegram->sendMessage($content);
		$log=$today. ";new chat started;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);

	}
	elseif ($text == "/meteo" || $text == "meteo") {
		$reply = "Previsioni Meteo per oggi " .$data->lamma_text("oggi").$data->biometeo_text("oggi");
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$log=$today. ";meteo sent;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);	
		}
	elseif ($text == "/previsioni" || $text == "previsioni") {
		$reply = "Previsioni Meteo per domani " .$data->lamma_text("domani").$data->biometeo_text("domani");
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$log=$today. ";previsioni sent;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	}
	elseif ($text == "/rischi" || $text == "rischi") {
		$reply = "Rischi di oggi:\r\n".$data->risk_text("oggi","B").$data->risk_text("oggi","R1");
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$log=$today. ";rischi sent;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	}
	elseif ($text == "/crediti" || $text == "crediti") {
	 $reply = "Applicazione sviluppata da Matteo Tempestini, dettagli e fonti dei dati presenti su : http://pratosmart.teo-soft.com/emergenzeprato/";
     $content = array('chat_id' => $chat_id, 'text' => $reply);
     $telegram->sendMessage($content);
	 $log=$today. ";crediti sent;" .$chat_id. "\n";
	 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);	
	}
	 
}


?>
