<?php
/**
 
	Script to send message in broadcast to a list of all subscribers
	
 */
include(dirname(__FILE__).'/../settings.php');
include('settings_t.php');


 
		$db = new PDO('sqlite:emergenzeprato.sqlite');

		date_default_timezone_set('Europe/Rome');
		$today = date("Y-m-d H:i:s");
		
		$update["message"]["from"]["id"]=2;

		$statement = "INSERT INTO ". DB_TABLE ." (user_id) VALUES ('" . $update["message"]["from"]["id"] . "')";
        $db->exec($statement);
		
       /* $statement = "SELECT * FROM ".DB_TABLE;
        echo $statement;
        $user = $db->query($statement);
        $user = $user->fetchAll();

        $i = 0;
        foreach ($user as $user_id) {
                    $i++;
                    $text = $message;
                    $telegram->sendMessageAll($type, $user_id[$i], $content);
                }
        
        echo 'Sent to '.$i.' subscribers.';
		

*/
?>
