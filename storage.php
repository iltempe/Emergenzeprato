#!/usr/bin/php

<?php

include('settings.php');

//da far girare con CRON nella folder corrente per salvare i file XML nella cartella data. Valutare indicativamente l'orario di aggiornamento delle fonti
date_default_timezone_set('UTC');
$today = date("Ymd");   

$logfile=(dirname(__FILE__).'/logs/storedata.log');

//si aggiorna verso le 10.00 del mattino
$biometeo_ITA_file = BIOMETEO_ITA_LINK;;
$biometeo_ENG_file = BIOMETEO_ENG_LINK;
//si aggiorna verso le 8.30 del mattino
$meteo_file = METEO_LINK;

//si aggiorna dalle 10 alle 13 del mattino
$risk_file = RISK_LINK. $today.".xml";

store($biometeo_ITA_file, "data/biometeo_ITA.xml",$logfile);
store($biometeo_ENG_file, "data/biometeo_ENG.xml",$logfile);
store($meteo_file, "data/meteo.xml",$logfile);

//cancello il file in locale in quanto cambia il nome da un giorno all'altro ed esiste un momento del giorno in cui non esiste il file (la mattina)
unlink ("data/risk.xml");
store($risk_file, "data/risk.xml",$logfile);

//download pics
download_remote_file(IDROMETRIA_Bisenzio_Prato,"data/IDROMETRIA_Bisenzio_Prato.jpg",$logfile);
download_remote_file(IDROMETRIA_Bisenzio_Vaiano_Gamberame,"data/IDROMETRIA_Bisenzio_Vaiano_Gamberame.jpg",$logfile);
download_remote_file(IDROMETRIA_Ombrone_PonteAlleVanne,"data/IDROMETRIA_Ombrone_PonteAlleVanne.jpg",$logfile);
download_remote_file(IDROMETRIA_Ombrone_PoggioACaiano,"data/IDROMETRIA_Ombrone_PoggioACaiano.jpg",$logfile);

download_remote_file(PLUVIOMETRIA_Prato_Città,"data/PLUVIOMETRIA_Prato_Città.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Prato_Università,"data/PLUVIOMETRIA_Prato_Università.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Galceti_Montemurlo,"data/PLUVIOMETRIA_Galceti_Montemurlo.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Vaiano_Gamberame,"data/PLUVIOMETRIA_Vaiano_Gamberame.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Vaiano_Acquedotto,"data/PLUVIOMETRIA_Vaiano_Acquedotto.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Fattoria_Iavello_Montemurlo,"data/PLUVIOMETRIA_Fattoria_Iavello_Montemurlo.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Cantagallo,"data/PLUVIOMETRIA_Cantagallo.jpg",$logfile);

download_remote_file(TERMOMETRIA_Prato_Università,"data/TERMOMETRIA_Prato_Università.jpg",$logfile);
download_remote_file(TERMOMETRIA_Galceti_Montemurlo,"data/TERMOMETIRIA_Galceti_Montemurlo.jpg",$logfile);

download_remote_file(ANEMOMETRIA_Prato_Università,"data/ANEMOMETRIA_Prato_Università.jpg",$logfile);
download_remote_file(ANEMOMETRIA_Galceti_Montemurlo,"data/ANEMOMETRIA_Galceti_Montemurlo.jpg",$logfile);

download_remote_file(IGROMETRIA_Prato_Città,"data/IGROMETRIA_Prato_Città.jpg",$logfile);
download_remote_file(IGROMETRIA_Galceti_Montemurlo,"data/IGROMETRIA_Galceti_Montemurlo.jpg",$logfile);
download_remote_file(IGROMETRIA_Vaiano_Acquedotto,"data/IGROMETRIA_Vaiano_Acquedotto.jpg",$logfile);


function download_remote_file($file_url, $save_to, $logfile)
	{		
		$today = date("Y-m-d H:i:s"); 
		$content = file_get_contents($file_url);
		file_put_contents($save_to, $content);
		$log=$today. ";" .$save_to." salvato\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	}


function store($xmlFile,$dest,$logfile)
{
	$today = date("Y-m-d H:i:s"); 
	if(!simplexml_load_file($xmlFile)) 
	{
		print($xmlFile. " non correttamente scaricato\r\n");
		$log=$today. ";" .$xmlFile." non correttamente scaricato\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	
	}
	else
	{
		$s = simplexml_load_file($xmlFile);
		$s->saveXML($dest);
		$log=$today. ";" .$xmlFile." salvato\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	}
}
?>
