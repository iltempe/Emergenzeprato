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

include("Telegram.php");
include("getdata.php");

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
		$reply = "Working";
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
	}
	if ($text == "/meteo") {
		$reply = $data->getdata();
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		print($today. " meteo sent \r\n");
	}
	if ($text == "/previsioni") {
		$reply = $data->getdata_tomorrow();
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		print($today. " previsioni sent \r\n");
	}
	if ($text == "/rischi") {
		$reply = $data->getdata_risk();
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		print($today. " rischi sent \r\n");
	}
	if ($text == "/test") {
		if ($telegram->messageFromGroup()) {
			$reply = "Chat Group";
		} else {
			$reply = "Private Chat";
		}
        // Create option for the custom keyboard. Array of array string
        $option = array( array("A", "B"), array("C", "D") );
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
	}
}

?>
