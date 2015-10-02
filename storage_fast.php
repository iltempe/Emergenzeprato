<?php
//modulo per la gestione dei dati provenienti dal sito protezione civile di Prato ed invio dell'allerta.
//è necessario uno storage locale del feed creato con page2rss della pagina web della protezione civile di Prato
//storage che può essere schedulato con un CRON (ogni minuto) in un file XML tramite la funzione get_prot() Storage Veloce.

include('settings.php');
date_default_timezone_set('Europe/Rome');

//salva i dati in locale
get_prot($logfile);

function get_prot()
{
	$prot_civ=PROT_CIV;

	//per memorizzare il dato
	store($prot_civ, dirname(__FILE__)."/data/prot.xml",'./logs/storedata.log');
}
	
//salvo i dati
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

