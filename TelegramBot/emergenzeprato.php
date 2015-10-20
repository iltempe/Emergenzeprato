<?php
/**
 * Telegram Bot example.
 * @author Matteo Tempestini
  * designed starting from https://github.com/Eleirbag89/TelegramBotPHP
 */

include(dirname(dirname(__FILE__)).'/getting.php');
include("Telegram.php");
include("OSMQueryLocation.php");


class emergenzeprato{
 
 //public $assembly_point_flag=false;
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
			//richiede previsioni meteo e rischio di domani
			elseif ($text == "/previsioni" || $text == "previsioni") {
				$reply = "Previsioni Meteo per domani " .$data->lamma_text("domani").$data->biometeo_text("domani");
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				
				if($data->risk_text("domani","B")!=null)
				{
					$reply = "Rischi previsti per domani:\r\n".$data->risk_text("domani","B").$data->risk_text("domani","R1");
				}else
				{
					$reply = "Rischi previsti per domani non ancora disponibili\r\n";
				}
				$content = array('chat_id' => $chat_id, 'text' => $reply);
				$telegram->sendMessage($content);
				$log=$today. ";previsioni sent;" .$chat_id. "\n";
			}
			//richiede rischi di oggi a Prato
			elseif ($text == "/rischi" || $text == "rischi") {
				if($data->risk_text("oggi","B")!=null)
				{
					$reply = "Rischi di oggi:\r\n".$data->risk_text("oggi","B").$data->risk_text("oggi","R1");
				}
				else
				{
					$reply = "Rischi previsti per oggi non ancora disponibili\r\n";
				}
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
				 - sapere l'area di assembramento più vicina e mappare una segnalazione inviando la posizione tramite la molletta in basso a sinistra.
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

			//----- gestione segnalazioni georiferite : togliere per non gestire le segnalazioni georiferite -----
			elseif($location!=null)
			{
				//comunico l'area di assembramento più vicina
				$this->aree_di_protezione_manager($db,$telegram,$user_id,$chat_id,$location);
				
				//gestisco eventuali segnalazioni commentare se si vuole disabilitare la gestione delle segnalazioni
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
				$option = array(["notifiche on","notifiche off"],["info","<-"]);
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
	
	//segnala le aree di assmbramento definite dalla protezione civile di Prato
	function aree_di_protezione_manager($db,$telegram,$user_id,$chat_id,$location)
	{
				
				date_default_timezone_set('Europe/Rome');
				$today = date("Y-m-d H:i:s");
				

				$lon=$location["longitude"];
				$lat=$location["latitude"];
				
				//prelevo dati da OSM sulla base della mia posizione
				$osm_data=give_osm_data($lat,$lon);
			   
				
				//rispondo inviando i dati di Openstreetmap
				$osm_data_dec = simplexml_load_string($osm_data);
				
				//per ogni nodo prelevo coordinate e nome
				foreach ($osm_data_dec->node as $osm_element) {
					$nome="";					
					foreach ($osm_element->tag as $key) {

						if ($key['k']=='name')
						{
							$nome=utf8_encode($key['v']);
							$content = array('chat_id' => $chat_id, 'text' =>$nome);
							$telegram->sendMessage($content);
						}
					}
					//gestione musei senza il tag nome
					if($nome=="")
					{
							$nome=utf8_encode("Punto di raccolta non identificato su Openstreetmap");
							$content = array('chat_id' => $chat_id, 'text' =>$nome);
							$telegram->sendMessage($content);
					}					
					$content_geo = array('chat_id' => $chat_id, 'latitude' =>$osm_element['lat'], 'longitude' =>$osm_element['lon']);
					$telegram->sendLocation($content_geo);
				 } 
				
				//crediti dei dati
				if((bool)$osm_data_dec->node)
				{
					$content = array('chat_id' => $chat_id, 'text' => utf8_encode("Questo il punto di raccolta vicino a te (dati forniti tramite OpenStreetMap. Licenza ODbL © OpenStreetMap contributors)"));
					$bot_request_message=$telegram->sendMessage($content);				
				}else
				{
					$content = array('chat_id' => $chat_id, 'text' => utf8_encode("Non ci sono punti di raccolta vicini, mi spiace! Se ne conosci uno nelle vicinanze mappalo su www.openstreetmap.org"));
					$bot_request_message=$telegram->sendMessage($content);	
				}				
}
		
		
		
}

?>
