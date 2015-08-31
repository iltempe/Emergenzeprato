#!/usr/bin/php

<?php

//da far girare con CRON nella folder corrente per salvare i file XML nella cartella data. Valutare indicativamente l'orario di aggiornamento delle fonti
date_default_timezone_set('UTC');
$today = date("Ymd");   

//si aggiorna verso le 10.00 del mattino
$biometeo_ITA_file = "http://data.biometeo.it/PRATO/PRATO_ITA.xml";
$biometeo_ENG_file = "http://data.biometeo.it/PRATO/PRATO_ENG.xml";
//si aggiorna verso le 8.30 del mattino
$meteo_file = "http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml";

//si aggiorna dalle 10 alle 13 del mattino
$risk_file = "http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml";
//$risk_file = "http://www.sir.toscana.it/supports/xml/risks_395/20150829.xml";



store($biometeo_ITA_file, "data/biometeo_ITA.xml");
store($biometeo_ENG_file, "data/biometeo_ENG.xml");
store($meteo_file, "data/meteo.xml");

//cancello il file in locale in quanto cambia il nome da un giorno all'altro ed esiste un momento del giorno in cui non esiste il file (la mattina)
unlink ("data/risk.xml");
store($risk_file, "data/risk.xml");

$logfile=(dirname(__FILE__).'/../logs/storedata.log');


function store($xmlFile,$dest)
{
	if(!simplexml_load_file($xmlFile)) 
	{
		print($xmlFile. " non correttamente scaricato\r\n");
		$log=$today ";" $xmlFile." non correttamente scaricato\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	
	}
	else
	{
		$s = simplexml_load_file($xmlFile);
		$s->saveXML($dest);
		$log=$today ";" $xmlFile." salvato\n";
		file_put_contents($logfile, $log, FILE_APPEND | LOCK_EX);
	}
}
?>
