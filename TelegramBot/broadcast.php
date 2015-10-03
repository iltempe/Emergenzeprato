<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */


//controlla le condizioni per gestire le notifiche automatiche (in fase di testing!)
function broadcast_manager($db,$telegram,$data)
{	
			//gestione allarmi da completare.
			if(check_alarm($data)) 
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
		
			}
			else
			{
				echo "Nessun allarme inviato";
			}					

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
				//echo "non ci sono aggiornamenti";
				return false;
			}
			else{
				if(new[0]!="" && new[1]!="")
				{
					$logged=$today. "-ci sono aggiornamenti: ". $old[0]. "-" .$old[1]. " a ". $new[0]. "-" .$new[1];
					file_put_contents(LOG_FILE, $logged, FILE_APPEND | LOCK_EX);
					return true;
				}else
				{
					return false;
				}
			}
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
        print_r($user_uni);
        $i = 0;
        foreach ($user_uni as $users) {
        		
        		//comment this to avoid broadcast message
                $telegram->sendMessageAll($type, $users['user_id'], $content);
                //print_r($user_uni);
                //print_r("invio a ".$users['user_id'].";");
                    
				//$content = array('chat_id' => $users['user_id'], 'text' => $content);
				//$telegram->sendMessage($content);
				$i++;
                }
        
    	$log=$today. ";Sent message ".$content. " to ".$i." subscribers\n";
    	file_put_contents(LOG_FILE, $log, FILE_APPEND | LOCK_EX);	
}

?>
