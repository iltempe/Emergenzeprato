<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */

 
//invia un dato in broadcast a tutti gli utenti iscritti
function sendMessagetoAll($db,$telegram,$type,$content){

		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
		
        $statement = "SELECT * FROM ".DB_TABLE;
        $user = $db->query($statement);
        $user = $user->fetchAll();
        $i = 0;
        foreach ($user as $user_id) {
        			//comment this to avoid broadcast message
                    //$telegram->sendMessageAll($type, $user[$i]['user_id'], $content);
					$i++;
                }
        
    	$log=$today. ";Sent message ".$content. " to ".$i." subscribers\n";
    	file_put_contents(LOG_FILE, $log, FILE_APPEND | LOCK_EX);	
}




?>
