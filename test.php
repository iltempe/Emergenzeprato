<?php

//file di test

include("getting.php");

$data=new getdata();

print("---Biometeo di Oggi---\r\n");
$test=$data->biometeo_text("oggi");
print($test);
print("---Biometeo di Domani---\r\n");
$test=$data->biometeo_text("domani");
print($test);
print("---Meteo di Oggi---\r\n");
$test1=$data->lamma_text("oggi");
print_r($test1);
print("---Meteo di Domani---\r\n");
$test1=$data->lamma_text("domani");
print_r($test1);
print("---Rischi di Oggi---\r\n");
$test=$data->risk_text("oggi","B");
print($test);
$test=$data->risk_text("oggi","R");
print($test);
print("---Rischi di Domani---\r\n");
$test=$data->risk_text("domani","B");
print($test);
$test=$data->risk_text("domani","R");
print($test);

        
//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml
//http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"

?>