<?php
/**
 * Telegram Bot example.
 * @author Gabriele Grillo <gabry.grillo@alice.it>
  * designed starting from https://github.com/Eleirbag89/TelegramBotPHP

 */

include(dirname(dirname(__FILE__)).'/getting.php');
include("Telegram.php");
include("broadcast.php");

class emergenzeprato{
 
 function start($telegram, $db, $update,$data)
	{
		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");

		/* If you need to manually take some parameters
		*  $result = $telegram->getData();
		*  $text = $result["message"] ["text"];
		*  $chat_id = $result["message"] ["chat"]["id"];
		*/

		//dati utili ricevuti dagli aggiornamenti
		$text = $update["message"] ["text"];
		$chat_id = $update["message"] ["chat"]["id"];
		$user_id=$update["message"]["from"]["id"];
		$location=$update["message"]["location"];
		$reply_to_msg=$update["message"]["reply_to_message"];
		
		$this->shell($telegram, $db,$data,$text,$chat_id,$user_id,$location,$reply_to_msg);

	}

	//gestisce l'interfaccia utente
	 function shell($telegram,$db,$data,$text,$chat_id,$user_id,$location,$reply_to_msg)
	{
		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");

		if ($text == "/start") {
				$log=$today. ";new chat started;" .$chat_id. "\n";
			}
			//richiedi previsioni meteo di oggi
			elseif ($text == "/meteo" || $text == "meteo") {
				$reply = "Previsioni Meteo per oggi " .$data->lamma_text("oggi").$data->biometeo_text("oggi");
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";meteo sent;" .$chat_id. "\n";
				}
			//richiede previsioni meteo di domani
			elseif ($text == "/previsioni" || $text == "previsioni") {
				$reply = "Previsioni Meteo per domani " .$data->lamma_text("domani").$data->biometeo_text("domani");
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";previsioni sent;" .$chat_id. "\n";
			}
			//richiede rischi di oggi a Prato
			elseif ($text == "/rischi" || $text == "rischi") {
				$reply = "Rischi di oggi:\r\n".$data->risk_text("oggi","B").$data->risk_text("oggi","R1");
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";rischi sent;" .$chat_id. "\n";
			}
			//crediti
			elseif ($text == "/info" || $text == "info") {
				 $reply = ("Emergenzeprato e' un servizio sperimentale e dimostrativo per segnalazioni meteo e rischio a Prato. 
				 Puoi:
				 - selezionare un'opzione in basso,
				 - digitare /on o /off nella chat per abilitare o disabilitare le notifiche automatiche (funzione in sperimentazione)
				 - mappare una segnalazione inviando la posizione tramite la molletta in basso a sinistra.
				 Applicazione sviluppata da Matteo Tempestini (Agosto 2015). Licenza MIT.
				 I dettagli e le fonti sono su : http://iltempe.github.io/Emergenzeprato/");
				 $content = array('chat_id' => $chat_id, 'text' => $reply);
				 $telegram->sendMessage($content);
				 $log=$today. ";crediti sent;" .$chat_id. "\n";
			}
			//richiede la temperatura
			elseif ($text == "/temperatura" || $text == "temperatura") {
			
	 			$log=$today. ";temp requested;" .$chat_id. "\n";
				$this->create_keyboard_temp($telegram,$chat_id);
				exit;	
			}
			elseif ($text =="Prato" || $text == "/temp-prato")
			{
				 $reply = "Temperatura misurata in zona Prato Est : " .$data->get_temperature("prato est");
				 $content = array('chat_id' => $chat_id, 'text' => $reply);
				 $telegram->sendMessage($content);
				 $log=$today. ";temperatura Prato sent;" .$chat_id. "\n";
			}
			elseif ($text =="Vaiano/Sofignano" || $text == "/temp-vaianosofignano")
			{
				 $reply = "Temperatura misurata in zona Vaiano/Sofignano : " .$data->get_temperature("vaiano sofignano");
				 $content = array('chat_id' => $chat_id, 'text' => $reply);
				 $telegram->sendMessage($content);
				 $log=$today. ";temperatura Vaiano/Sofignano sent;" .$chat_id. "\n";
			}
			elseif ($text =="Vaiano/Schignano" || $text == "/temp-vaianoschignano")
			{
				 $reply = "Temperatura misurata in zona Vaiano/Schignano : " .$data->get_temperature("vaiano schignano");
				 $content = array('chat_id' => $chat_id, 'text' => $reply);
				 $telegram->sendMessage($content);
				 $log=$today. ";temperatura Vaiano/Schignano sent;" .$chat_id. "\n";
			}
			elseif ($text =="Montepiano/Vernio" || $text == "/temp-montepianovernio")
			{
				 $reply = "Temperatura misurata in zona Montepiano/Vernio : " .$data->get_temperature("montepiano vernio");
				 $content = array('chat_id' => $chat_id, 'text' => $reply);
				 $telegram->sendMessage($content);
				 $log=$today. ";temperatura Montepiano/Vernio sent;" .$chat_id. "\n";

			}
			elseif ($text=="bisenzio" || $text =="/bisenzio")
			{
				//invio immagini stazioni meteo
				$photo="@". dirname(__FILE__).'/../data/IDROMETRIA_Bisenzio_Prato.jpg';
				$content = array('chat_id' => $chat_id, 'photo' => $photo);
				$telegram->sendPhoto($content);
				$log=$today. ";livello Bisenzio sent;" .$chat_id. "\n";
			} 
			elseif ($text=="notifiche on" || $text =="/on")
			{
				//abilita disabilita le notifiche automatiche del servizio
				//memorizza lo user_id
            	$statement = "INSERT INTO " . DB_TABLE ." (user_id) VALUES ('" . $user_id . "')";
            	$db->exec($statement);
				$reply = "Notifiche da emergenzeprato abilitate";
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";notification set;" .$chat_id. "\n";
			} 
			elseif ($text=="notifiche off" || $text =="/off")
			{
				//abilita disabilita le notifiche automatiche del servizio
				//memorizza lo user_id
            	$statement = "DELETE FROM ". DB_TABLE ." where user_id = '" . $user_id . "'";
            	$db->exec($statement);
				$reply = "Notifiche da emergenzeprato disabilitate";
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";notification reset;" .$chat_id. "\n";
			}
			elseif ($text=="->")
			{
				$this->create_keyboard_2($telegram,$chat_id);
				exit;
			}
			elseif ($text=="<-")
			{
				$this->create_keyboard($telegram,$chat_id);
				exit;
			}
			elseif ($text=="aree di protezione" || $text=="/aree")
			{
				$reply = "Comando in sviluppo";
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";aree request;" .$chat_id. "\n";	

			}

			//----- gestione segnalazioni georiferite : togliere per non gestire le segnalazioni georiferite -----
			elseif($location!=null)
			{

				$this->location_manager($db,$telegram,$user_id,$chat_id,$location);
				
				//db
				$statement = "INSERT INTO " . DB_TABLE_LOG ." (date, text, chat_id, user_id, location, reply_to_msg) VALUES ('" . $today . "','" . $text . "','" . $chat_id . "','" . $user_id . "','" . $location . "','" . $reply_to_msg . "')";
            	$db->exec($statement);
				exit;	

			}
			elseif($reply_to_msg!=null)
			{
				//inserisce la segnalazione nel DB delle segnalazioni georiferite
				$statement = "UPDATE ".DB_TABLE_GEO ." SET text='".$text."' WHERE bot_request_message ='".$reply_to_msg['message_id']."'";
				print_r($reply_to_msg['message_id']);
				$db->exec($statement);
				$reply = "Segnalazione Registrata. Grazie!";
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";information for maps recorded;" .$chat_id. "\n";	
				
				//aggiorno dati mappa
				exec('sqlite3 -header -csv emergenzeprato.sqlite "select * from segnalazioni;" > map_data.csv');
			}
			// ----- ------------------------------------------------------------------------------------------
			
			//comando errato
			else{
				 $reply = "Hai selezionato un comando non previsto";
				 $content = array('chat_id' => $chat_id, 'text' => $reply);
				 $telegram->sendMessage($content);
				 $log=$today. ";wrong command sent;" .$chat_id. "\n";
			 }
			
			
			//aggiorna tastiera
			$this->create_keyboard($telegram,$chat_id);
			
			//log			
			file_put_contents(LOG_FILE, $log, FILE_APPEND | LOCK_EX);
			
			//db
			$statement = "INSERT INTO " . DB_TABLE_LOG ." (date, text, chat_id, user_id, location, reply_to_msg) VALUES ('" . $today . "','" . $text . "','" . $chat_id . "','" . $user_id . "','" . $location . "','" . $reply_to_msg . "')";
            $db->exec($statement);
			
	}

	// Crea la tastiera
	 function create_keyboard($telegram, $chat_id)
		{
				$option = array(["meteo","previsioni"],["rischi","temperatura"],["bisenzio","->"]);
				$keyb = $telegram->buildKeyBoard($option, $onetime=false);
				$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "[seleziona un'opzione per essere aggiornato]");
				$telegram->sendMessage($content);
		}
		
	//Crea la seconda tastiera
	function create_keyboard_2($telegram, $chat_id)
		{
				$option = array(["notifiche on","notifiche off"],["aree di protezione","info"],["<-"]);
				$keyb = $telegram->buildKeyBoard($option, $onetime=false);
				$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "[seleziona un'opzione per essere aggiornato]");
				$telegram->sendMessage($content);
		}

	//crea la tastiera per scegliere la zona temperatura
	 function create_keyboard_temp($telegram, $chat_id)
		{
				$option = array(["Prato","Vaiano/Sofignano"],["Vaiano/Schignano", "Montepiano/Vernio"]);
				$keyb = $telegram->buildKeyBoard($option, $onetime=false);
				$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "[seleziona la zona di cui vuoi sapere la temperatura]");
				$telegram->sendMessage($content);
		}
		
	//controlla le condizioni per gestire le notifiche automatiche (in fase di testing!)
	function broadcast_manager($db,$telegram,$data)
		{
			//gestione allarmi da completare.
			if($this->check_alarm($data)) 
			{
				date_default_timezone_set('Europe/Rome');
				$today = date("Y-m-d H:i:s");
				$load_data=$data->load_prot(false);

				$message=$load_data[0]. "\n" ."segnalazione del\n". $load_data[1]. "\n". "per i dettagli consultare il sito della protezione civile di Prato http://www.protezionecivile.comune.prato.it/emergenze/";
				
				//commmentare qui se si vuole inibire le notifiche automatiche
				sendMessagetoAll($db,$telegram,'message',$message); 
				
				//registro l'allerta nel DB
				$statement = "INSERT INTO " . DB_TABLE_LOG ." (date, text, chat_id, user_id, location, reply_to_msg) VALUES ('" . $today . "','" . $load_data[0] . "','" . $load_data[1] . "','" . "all" . "','" . " " . "','" . " " . "')";
				$db->exec($statement);
				
				//update file
				$data->update_prot($load_data);
				echo "Allarme inviato";
		
			}else
			{
				echo "Nessun allarme inviato";
			}					

		}
	//controlla la posizione e chiede quale segnalazione si deve fare
	function location_manager($db,$telegram,$user_id,$chat_id,$location)
		{
				$lng=$location["longitude"];
				$lat=$location["latitude"];
				
				//rispondo
				$response=$telegram->getData();
				$bot_request_message_id=$response["message"]["message_id"];
				
				//nascondo la tastiera e forzo l'utente a darmi una risposta
				$forcehide=$telegram->buildForceReply(true);

				//chiedo cosa sta accadendo nel luogo
				$content = array('chat_id' => $chat_id, 'text' => "[Cosa sta accadendo qui?]", 'reply_markup' =>$forcehide, 'reply_to_message_id' =>$bot_request_message_id);
				$bot_request_message=$telegram->sendMessage($content);
				
				//memorizzare nel DB
				$obj=json_decode($bot_request_message);
				$id=$obj->result;
				$id=$id->message_id;
				//print_r($id);
				$statement = "INSERT INTO ". DB_TABLE_GEO. " (lat,lng,user,text,bot_request_message) VALUES ('" . $lat . "','" . $lng . "','" . $user_id . "',' ','". $id ."')";
            	$db->exec($statement);
		}
		
		//verifica se esiste un allarme da inviare broadcast
		//inserire qui la logica secondo la quale si vuole inviare un messaggio broadcast
	function check_alarm($data)
		{
			//controllo se la protezione civile ha aggiornato i dati dell'emergenza
			$old=$data->load_prot(true);
			$new=$data->load_prot(false);

			$today = date("Y-m-d H:i:s");

			if(array_diff($new,$old)==null)
			{
				echo "non ci sono aggiornamenti";
				return false;
			}
			else{
				$logged=$today. "-ci sono aggiornamenti: ". $old[0]. "-" .$old[1]. " a ". $new[0]. "-" .$new[1];
				file_put_contents(LOG_FILE, $logged, FILE_APPEND | LOCK_EX);
				return true;
			}
		}
		
}

?>
