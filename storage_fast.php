<?php
//modulo per la gestione dei dati provenienti dal sito protezione civile di Prato

function get_prot()
{
	date_default_timezone_set('UTC');

	$logfile=(dirname(__FILE__).'/logs/storedata.log');

	//scrape protezione civile feed
	define("PROT_CIV", "http://page2rss.com/rss/28dbb41c5e425167e4d73bf1b00dd7cd");
	$prot_civ=PROT_CIV;

	//per memorizzare il dato
	//store($prot_civ, dirname(__FILE__)."/data/prot.xml",$logfile);

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
		$data[2]=$xml_file->channel->item->description;
		print_r($data[2]);
		return $data;
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

