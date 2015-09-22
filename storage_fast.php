<?php
//modulo per la gestione dei dati provenienti dal sito protezione civile di Prato

define("PROT_CIV", "http://page2rss.com/rss/28dbb41c5e425167e4d73bf1b00dd7cd");

function get_prot()
{
	$prot_civ=PROT_CIV;

	//per memorizzare il dato
	store($prot_civ, dirname(__FILE__)."/data/prot.xml",$logfile);
}


function load_prot($islocal)
{
	date_default_timezone_set('UTC');

	$logfile=(dirname(__FILE__).'/logs/storedata.log');
	
	if($islocal)
	{
		//carico dati salvati in locale per confrontarli con quelli remoti
		$prot_civ=dirname(__FILE__)."/data/prot.xml";
	}
	else
	{
		//carico dati salvati in remoto
		$prot_civ=PROT_CIV;
	}

	$xml_file=simplexml_load_file($prot_civ); 

	if ($xml_file==false)
		{
			print("Errore nella ricerca del file relativo alla protezione civile");
		}
		
		//ritorna il primo elemento del feed rss
		$data[0]=$xml_file->channel->item->title;
		print_r($data[0]);
		$data[1]=$xml_file->channel->item->pubDate;
		print_r($data[1]);
		return $data;
}


function isequal_check($source, $dest)
{
	if($source==$dest)
	{
		return true;
	}
	else
	{
		return false;
	}
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

//da inserire dove si vuol fare il controllo



?>

