#!/usr/bin/php

<?php

//main file to define and send alert
//to be managed as CRON JOB to send alert 
//NOT USED YET

require_once __DIR__.'/./settings.php';
require_once __DIR__.'/./getting.php';
require_once __DIR__.'/./IOT/sound.php';

// file di appoggio per i dati
$file =  __DIR__.'/data/alarm.txt';

//preparo il getter
$data= new getdata();

//prelevo il dato attuale dal sito
$current[0]=$data->select_risk_data("oggi", "B", "idrogeologico");
$current[1]=$data->select_risk_data("oggi", "B", "idraulico");
$current[2]=$data->select_risk_data("oggi", "B", "vento");
$current[3]=$data->select_risk_data("oggi", "B", "mareggiate");
$current[4]=$data->select_risk_data("oggi", "B", "neve");
$current[5]=$data->select_risk_data("oggi", "B", "ghiaccio");
$current[6]=$data->select_risk_data("oggi", "B", "temporali");
print_r($file);

	//stampo il file (la prima volta)
	if(!file_exists($file))
		{
			file_put_contents($file, "allarme non inviato");
		}

if ($current[0]!="nessuno" || $current[1]!="nessuno" || $current[2]!="nessuno" || $current[3]!="nessuno" || $current[4]!="nessuno" || $current[5]!="nessuno" || $current[6]!="nessuno")
{

		//se il file esiste già fare il confronto
		$old=file_get_contents($file);

		if($old!="allarme inviato")
			{
				send_alert($current);
				file_put_contents($file, "allarme inviato");
			}
		else
			{
				//se non ci sono aggiornamenti non fare nulla
			}

}
//function to send alert if ther is some risk
function send_alert($current)
{
	//inserire cosa fare in caso di invio allerta
	print_r("invio allerta");
	audio_play("/home/pi/emergenzeprato/audio/siren_noise.mp3");

}


			
?>
