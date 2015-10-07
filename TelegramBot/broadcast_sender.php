<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */
//TO BE USED WITH AN ALERT FILE IN AN APPLICATION (LIKE EMERGENZEPRATO)
include(dirname(__FILE__).'/../settings.php');
include('settings_t.php');
include("emergenzeprato.php");


function broadcast_go($current)
{
	date_default_timezone_set('Europe/Rome');
	$today = date("Y-m-d H:i:s"); 
	
	$db = new PDO(DB_NAME);

	$update_manager= new emergenzeprato();
	
	//istanzia oggetto Telegram
	$bot_id = TELEGRAM_BOT;
	$bot = new Telegram($bot_id);
	
	//inizializzo il bot
	$bot->init();
	
	//gestore broadcast
	broadcast_manager($db,$bot,$current);

}

//controlla le condizioni per gestire le notifiche automatiche (in fase di testing!)
function broadcast_manager($db,$telegram,$current)
{	
				date_default_timezone_set('Europe/Rome');
				$today = date("Y-m-d H:i:s");

				$message= limit_text($current);
				
				//commmentare qui se si vuole inibire le notifiche automatiche
				sendMessagetoAll($db,$telegram,'message',$message); 
				
				//registro l'allerta nel DB
				$statement = "INSERT INTO " . DB_TABLE_LOG ." (date, text, chat_id, user_id, location, reply_to_msg) VALUES ('" . $today . "','" . $load_data[0] . "','" . $load_data[1] . "','" . "all" . "','" . " " . "','" . " " . "')";
				$db->exec($statement);
				
				//update file
				echo "Allarme inviato";				
}

 
//invia un dato in broadcast a tutti gli utenti iscritti
function sendMessagetoAll($db,$telegram,$type,$content){

		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
		
        $statement = "SELECT * FROM ".DB_TABLE;
        $user = $db->query($statement);
        $user = $user->fetchAll();
        
        //remove duplicates 
        $user_uni=array_unique($user,SORT_REGULAR);
        print_r($content);
        $i = 0;
        foreach ($user_uni as $users) {
        		
        		//COMMENT TO AVOID BRODCAST
        		$telegram->sendMessageAll($type, $users['user_id'], $content);
                $i++;
                }
        
    	$log=$today. ";Sent message ".$content. " to ".$i." subscribers\n";
    	file_put_contents(LOG_FILE, $log, FILE_APPEND | LOCK_EX);	
}



function limit_text($text, $limit=100,$append="...leggi tutto su http://www.protezionecivile.comune.prato.it/emergenze/") {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text. $append;
    }


?>
