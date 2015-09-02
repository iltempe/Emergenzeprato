<?php
/**
 * Telegram Bot example.
 * @author Gabriele Grillo <gabry.grillo@alice.it>
  * designed starting from https://github.com/Eleirbag89/TelegramBotPHP

 */

include('settings.php');
include('getting.php');
include("Telegram.php");
 
$logfile=(dirname(__FILE__).'/./telegram.log');

date_default_timezone_set('Europe/Rome');
$today = date("Y-m-d H:i:s");

// Set the bot TOKEN in setting.php
$bot_id = TELEGRAM_BOT;
// Instances the class
$data=new getdata();
$telegram = new Telegram($bot_id);

/* If you need to manually take some parameters
*  $result = $telegram->getData();
*  $text = $result["message"] ["text"];
*  $chat_id = $result["message"] ["chat"]["id"];
*/

// Take text and chat_id from the message
//$text = $telegram->Text();
//$chat_id = $telegram->ChatID();

$result = $telegram->getData();
$text = $result["message"] ["text"];
$chat_id = $result["message"] ["chat"]["id"];

if ($text == "/start") {
    	create_keyboard($telegram,$chat_id);
		$log=$today. ";new chat started;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	}
	//richiedi previsioni meteo di oggi
	elseif ($text == "/meteo" || $text == "meteo") {
		$reply = "Previsioni Meteo per oggi " .$data->lamma_text("oggi").$data->biometeo_text("oggi");
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$log=$today. ";meteo sent;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		//aggiorna tastiera
	    create_keyboard($telegram,$chat_id);	
		}
	//richiede previsioni meteo di domani
	elseif ($text == "/previsioni" || $text == "previsioni") {
		$reply = "Previsioni Meteo per domani " .$data->lamma_text("domani").$data->biometeo_text("domani");
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$log=$today. ";previsioni sent;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		//aggiorna tastiera
	   create_keyboard($telegram,$chat_id);
	}
	//richiede rischi di oggi a Prato
	elseif ($text == "/rischi" || $text == "rischi") {
		$reply = "Rischi di oggi:\r\n".$data->risk_text("oggi","B").$data->risk_text("oggi","R1");
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$log=$today. ";rischi sent;" .$chat_id. "\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		//aggiorna tastiera
	  	create_keyboard($telegram,$chat_id);
	}
	//crediti
	elseif ($text == "/crediti" || $text == "crediti") {
		 $reply = "Applicazione sviluppata da Matteo Tempestini, dettagli e fonti dei dati presenti su : http://pratosmart.teo-soft.com/emergenzeprato/";
		 $content = array('chat_id' => $chat_id, 'text' => $reply);
		 $telegram->sendMessage($content);
		 $log=$today. ";crediti sent;" .$chat_id. "\n";
		 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		 //aggiorna tastiera
		 create_keyboard($telegram,$chat_id);
	}
	//richiede la temperatura
	elseif ($text == "/temperatura" || $text == "temperatura") {
	 
	 	 create_keyboard_temp($telegram,$chat_id);	
	}
	elseif ($text =="Prato" || $text == "/temp-prato")
	{
		 $reply = "Temperatura misurata in zona Prato Est : " .$data->get_temperature("prato est");
		 $content = array('chat_id' => $chat_id, 'text' => $reply);
		 $telegram->sendMessage($content);
		 $log=$today. ";temperatura Prato sent;" .$chat_id. "\n";
		 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		 //aggiorna tastiera
		 create_keyboard($telegram,$chat_id);
	}
	elseif ($text =="Vaiano/Sofignano" || $text == "/temp-vaianosofignano")
	{
		 $reply = "Temperatura misurata in zona Vaiano/Sofignano : " .$data->get_temperature("vaiano sofignano");
		 $content = array('chat_id' => $chat_id, 'text' => $reply);
		 $telegram->sendMessage($content);
		 $log=$today. ";temperatura Vaiano/Sofignano sent;" .$chat_id. "\n";
		 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		 //aggiorna tastiera
		 create_keyboard($telegram,$chat_id);
	}
	elseif ($text =="Vaiano/Schignano" || $text == "/temp-vaianoschignano")
	{
		 $reply = "Temperatura misurata in zona Vaiano/Schignano : " .$data->get_temperature("vaiano schignano");
		 $content = array('chat_id' => $chat_id, 'text' => $reply);
		 $telegram->sendMessage($content);
		 $log=$today. ";temperatura Vaiano/Schignano sent;" .$chat_id. "\n";
		 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		 //aggiorna tastiera
		 create_keyboard($telegram,$chat_id);
	}
	elseif ($text =="Montepiano/Vernio" || $text == "/temp-montepianovernio")
	{
		 $reply = "Temperatura misurata in zona Montepiano/Vernio : " .$data->get_temperature("montepiano vernio");
		 $content = array('chat_id' => $chat_id, 'text' => $reply);
		 $telegram->sendMessage($content);
		 $log=$today. ";temperatura Montepiano/Vernio sent;" .$chat_id. "\n";
		 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
		 //aggiorna tastiera
		 create_keyboard($telegram,$chat_id);
	}
	//comando errato
	else{
		 $reply = "Hai selezionato un comando non previsto. Per informazioni visita : http://pratosmart.teo-soft.com/emergenzeprato/";
		 $content = array('chat_id' => $chat_id, 'text' => $reply);
		 $telegram->sendMessage($content);
		 $log=$today. ";wrong command sent;" .$chat_id. "\n";
		 file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);	
	 }


// Crea la tastiera
function create_keyboard($telegram, $chat_id)
{
		$option = array(["meteo","previsioni"],["rischi", "temperatura"],["crediti"]);
    	$keyb = $telegram->buildKeyBoard($option, $onetime=false);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Seleziona un'opzione per essere aggiornato");
		$telegram->sendMessage($content);
}

//crea la tastiera per scegliere la zona temperatura
function create_keyboard_temp($telegram, $chat_id)
{
		$option = array(["Prato","Vaiano/Sofignano"],["Vaiano/Schignano", "Montepiano/Vernio"]);
    	$keyb = $telegram->buildKeyBoard($option, $onetime=false);
    	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Seleziona la zona di cui vuoi sapere la temperatura");
		$telegram->sendMessage($content);

}

?>
