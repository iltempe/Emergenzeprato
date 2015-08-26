#!/usr/bin/php

<?php

//da far girare con CRON nella folder corrente per salvare i file XML nella cartella data
date_default_timezone_set('UTC');
$today = date("Ymd");   

$biometeo_ITA_file = "http://data.biometeo.it/PRATO/PRATO_ITA.xml";
$biometeo_ENG_file = "http://data.biometeo.it/PRATO/PRATO_ENG.xml";
$meteo_file = "http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml";
$risk_file = "http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml";

store($biometeo_ITA_file, "data/biometeo_ITA.xml");
store($biometeo_ENG_file, "data/biometeo_ENG.xml");
store($meteo_file, "data/meteo.xml");
store($risk_file, "data/risk.xml");

function store($xmlFile,$dest)
{
	if( !simplexml_load_file($xmlFile) ) die('Missing file: ' . $xmlFile);
	else
	{
		$s = simplexml_load_file($xmlFile);
		$s->saveXML($dest);
	}
}
?>