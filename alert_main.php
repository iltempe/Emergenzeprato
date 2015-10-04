#!/usr/bin/php

<?php

//main file to define and send alert
//to be managed as CRON JOB

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

//stampo il file (basta la prima volta)
if(!file_exists($file))
{
	$current=$titolo[0]. "\n". $descrizione[1][1];
	file_put_contents($file, $current);
}
else{
	//se il file esiste già fare il confronto

}
			
?>

