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

store($biometeo_ITA_file, dirname(__FILE__)."/data/biometeo_ITA.xml",$logfile);
store($biometeo_ENG_file,dirname(__FILE__). "/data/biometeo_ENG.xml",$logfile);
store($meteo_file, dirname(__FILE__). "/data/meteo.xml",$logfile);

//cancello il file in locale in quanto cambia il nome da un giorno all'altro ed esiste un momento del giorno in cui non esiste il file (la mattina)
unlink (dirname(__FILE__)."/data/risk.xml");
store($risk_file, dirname(__FILE__)."/data/risk.xml",$logfile);

//download pics
download_remote_file(IDROMETRIA_Bisenzio_Prato,dirname(__FILE__)."/data/IDROMETRIA_Bisenzio_Prato.jpg",$logfile);
download_remote_file(IDROMETRIA_Bisenzio_Vaiano_Gamberame,dirname(__FILE__)."/data/IDROMETRIA_Bisenzio_Vaiano_Gamberame.jpg",$logfile);
download_remote_file(IDROMETRIA_Ombrone_PonteAlleVanne,dirname(__FILE__)."/data/IDROMETRIA_Ombrone_PonteAlleVanne.jpg",$logfile);
download_remote_file(IDROMETRIA_Ombrone_PoggioACaiano,dirname(__FILE__)."/data/IDROMETRIA_Ombrone_PoggioACaiano.jpg",$logfile);

download_remote_file(PLUVIOMETRIA_Prato_Città,dirname(__FILE__)."/data/PLUVIOMETRIA_Prato_Città.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Prato_Università,dirname(__FILE__)."/data/PLUVIOMETRIA_Prato_Università.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Galceti_Montemurlo,dirname(__FILE__)."/data/PLUVIOMETRIA_Galceti_Montemurlo.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Vaiano_Gamberame,dirname(__FILE__)."/data/PLUVIOMETRIA_Vaiano_Gamberame.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Vaiano_Acquedotto,dirname(__FILE__)."/data/PLUVIOMETRIA_Vaiano_Acquedotto.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Fattoria_Iavello_Montemurlo,dirname(__FILE__)."/data/PLUVIOMETRIA_Fattoria_Iavello_Montemurlo.jpg",$logfile);
download_remote_file(PLUVIOMETRIA_Cantagallo,dirname(__FILE__)."/data/PLUVIOMETRIA_Cantagallo.jpg",$logfile);

download_remote_file(TERMOMETRIA_Prato_Università,dirname(__FILE__)."/data/TERMOMETRIA_Prato_Università.jpg",$logfile);
download_remote_file(TERMOMETRIA_Galceti_Montemurlo,dirname(__FILE__)."/data/TERMOMETIRIA_Galceti_Montemurlo.jpg",$logfile);

download_remote_file(ANEMOMETRIA_Prato_Università,dirname(__FILE__)."/data/ANEMOMETRIA_Prato_Università.jpg",$logfile);
download_remote_file(ANEMOMETRIA_Galceti_Montemurlo,dirname(__FILE__)."/data/ANEMOMETRIA_Galceti_Montemurlo.jpg",$logfile);

download_remote_file(IGROMETRIA_Prato_Città,dirname(__FILE__)."/data/IGROMETRIA_Prato_Città.jpg",$logfile);
download_remote_file(IGROMETRIA_Galceti_Montemurlo,dirname(__FILE__)."/data/IGROMETRIA_Galceti_Montemurlo.jpg",$logfile);
download_remote_file(IGROMETRIA_Vaiano_Acquedotto,dirname(__FILE__)."/data/IGROMETRIA_Vaiano_Acquedotto.jpg",$logfile);


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
