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

include(dirname(__FILE__).'/../getdata.php');
include("Telegram.php");

date_default_timezone_set('Europe/Rome');
$today = date("Y-m-d H:i:s"); 

$bot_id = "";
$telegram = new Telegram($bot_id);
$data=new getdata();

// Get all the new updates and set the new correct update_id
$req = $telegram->getUpdates();
for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
	// You NEED to call serveUpdate before accessing the values of message in Telegram Class
	$telegram->serveUpdate($i);
	$text = $telegram->Text();
	$chat_id = $telegram->ChatID();

	if ($text == "/start") {
		 $option = array( array("meteo","previsioni", "rischi", "crediti") );
    	// Crea la tastiera
    	$keyb = $telegram->buildKeyBoard($option, $onetime=false);
    	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Benvenuto in emergenzeprato, seleziona la tua opzione per essere aggiornato");
		$telegram->sendMessage($content);
		print($today. " new chat started " .$chat_id. "\r\n");
	}
	if ($text == "/meteo" || $text == "meteo") {
		$reply = $data->getdata();
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		print($today. " meteo sent " .$chat_id. "\r\n");
	}
	if ($text == "/previsioni" || $text == "previsioni") {
		$reply = $data->getdata_tomorrow();
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		print($today. " previsioni sent " .$chat_id. "\r\n");
	}
	if ($text == "/rischi" || $text == "rischi") {
		$reply = $data->getdata_risk();
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		print($today. " rischi sent " .$chat_id. "\r\n");
	}
	if ($text == "/crediti" || $text == "crediti") {
	 $reply = "Applicazione sviluppata da Matteo Tempestini, dettagli e fonti dei dati presenti su : http://pratosmart.teo-soft.com/emergenzeprato/";
     $content = array('chat_id' => $chat_id, 'text' => $reply);
     $telegram->sendMessage($content);
     print($today. " crediti sent " .$chat_id. "\r\n");		
	}
}

?>
