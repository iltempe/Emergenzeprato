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

include('settings.php');
include("emergenzeprato.php");

//aggiorna con getUpdates
function getUpdates($telegram){
	
	date_default_timezone_set('Europe/Rome');
	$today = date("Y-m-d H:i:s"); 
	
	$logfile=(dirname(__FILE__).'/../logs/telegram.log');

	//$telegram = new Telegram($bot_id);

	$data=new getdata();

	$update_manager= new emergenzeprato();
	
	// Get all the new updates and set the new correct update_id
	$req = $telegram->getUpdates();

	for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
		// You NEED to call serveUpdate before accessing the values of message in Telegram Class
		$telegram->serveUpdate($i);
		$text = $telegram->Text();
		$chat_id = $telegram->ChatID();
		$update_manager->shell($telegram,$chat_id,$data,LOG_FILE,$text);

	}
}

?>
