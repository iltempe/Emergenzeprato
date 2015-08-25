<?php

//storagedata per XML #emergenzeprato
//by MT 
//creare nella cartella /data i file .xml template
//da terminare se troppo lento

date_default_timezone_set('UTC');
$today = date("Ymd");   

//si aggiorna verso le 13
$xml_1 = file_get_contents("http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"); 			// your file is in the string "$xml" now.
file_put_contents("data/risk.xml", $xml_1); 															// now your xml file is update.

//si aggiorna verso le 10
$xml_2 = file_get_contents("http://data.biometeo.it/PRATO/PRATO_ITA.xml"); 								// your file is in the string "$xml" now.
file_put_contents("data/biometeo_ita.xml", $xml_2); 													// now your xml file is saved.

$xml_3 = file_get_contents("http://data.biometeo.it/PRATO/PRATO_ENG.xml"); 								// your file is in the string "$xml" now.
file_put_contents("data/biometeo_eng.xml", $xml_3); 													// now your xml file is saved.

$xml_4 = file_get_contents("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml"); // your file is in the string "$xml" now.
file_put_contents("data/meteo.xml", $xml_4); 															// now your xml file is saved.

//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml

?>