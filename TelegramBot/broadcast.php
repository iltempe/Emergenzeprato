<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */
include(dirname(__FILE__).'/../settings.php');
include('settings_t.php');

 
//invia un dato in broadcast a tutti gli utenti iscritti
function sendMessagetoAll($db,$telegram,$type,$content){

		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
		
        $statement = "SELECT * FROM ".DB_TABLE;
        $user = $db->query($statement);
        $user = $user->fetchAll();
        $i = 0;
        foreach ($user as $user_id) {
                    $i++;
                    $telegram->sendMessageAll($type, $user[$i]['user_id'], $content);
                }
        
    	$log=$today. ";Sent message to ".$i." subscribers\n";
    	file_put_contents(LOG_FILE, $log, FILE_APPEND | LOCK_EX);	
}


//verifica se esiste un allarme da inviare broadcast
function check_alarm()
{
	//TBD per ora non invia mai messaggi in broadcast
	return false;

}

?>
