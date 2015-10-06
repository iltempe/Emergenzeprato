#!/usr/bin/php

<?php

//main file to define and send alert
//to be managed as CRON JOB to send alert 

require_once __DIR__.'/./HTMLscraper/src/ScraperInterface.php';
require_once __DIR__.'/./HTMLscraper/src/Scraper.php';
require_once __DIR__.'/./settings.php';

$file = dirname(__FILE__).'/data/protezione_civile.txt';

$object = new Scraper();

//eseguo lo scrape della pagina
$html = file_get_contents(PROT_CIV);

// seleziono titolo
$titolo = $object->execute('#head1 h1', $html);	

//seleziono il contenuto
$descrizione = $object->execute('#main div div', $html);

//rimuovo testo inutile
$descrizione=array_delete($descrizione[1],'Numero verde emergenze 800 30 15 30 
    
      
        Gallerie  fotografiche
      
      
        Video delle emergenze
      
      
        Meteo a Prato  e dintorni
        
      
        Comportamenti in caso di...');

$descrizione=implode("','",$descrizione);

$current=$titolo[0]. "\n". $descrizione;

//stampo il file (basta la prima volta)
if(!file_exists($file))
{
	file_put_contents($file, $current);
}
else{
	
	//se il file esiste già fare il confronto
	$old=file_get_contents($file);
	if($old!=$current)
	{
	
		send_alert();
		file_put_contents($file, $current);
	
	}
	else
	{
		//se non ci sono aggiornamenti non fare nulla
	
	}
}


function send_alert()
{

	//inserire cosa fare in caso di invio allerta
	print_r("invio allerta");

}

function array_delete($array, $element) {
    return array_diff($array, [$element]);
}
			
?>

