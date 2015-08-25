<?php

//Getdata per XML #emergenzeprato
//by MT 



date_default_timezone_set('UTC');
$today = date("Ymd");   

//Gestione Rischio Centro Funzionale Regione Toscana
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"); 

if ($sir_xml==false)
	{
	print("Errore nella ricerca del file relativo al rischio");
	$data="Rischi di oggi non ancora disponibili, riprova tra un po' ";
	
}else{

print($sir_xml->rischi[0]->rischio[0]->area[7]->impatto);
print($sir_xml->rischi[1]->rischio[0]->area[7]->impatto);

//print($sir_xml->rischi->rischio[0]);

//In zona B
//$sir_str_1_1=("Rischio idrogeologico a Prato: " .$sir_xml->rischi->rischio[0]->area[7]->impatto. "\r\n");
//$sir_str_2_1_1=("Rischio idraulico a Prato: " .$sir_xml->rischi->rischio[1]->area[7]->impatto. "\r\n");
//$sir_str_2_1=("Rischio vento a Prato: " .$sir_xml->rischi->rischio[2]->area[7]->impatto. "\r\n");
//$sir_str_3_1=("Rischio mareggiate a Prato: " .$sir_xml->rischi->rischio[3]->area[7]->impatto. "\r\n");
//$sir_str_4_1=("Rischio neve a Prato: " .$sir_xml->rischi->rischio[4]->area[7]->impatto. "\r\n");
//$sir_str_5_1=("Rischio ghiaccio a Prato: " .$sir_xml->rischi->rischio[5]->area[7]->impatto. "\r\n");
//$sir_str_5_1_1=("Rischio temporali a Prato: " .$sir_xml->rischi->rischio[6]->area[7]->impatto. "\r\n");

//In zona R1
//$sir_str_1_2=("#cfr rischio #idrogeologico #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[0]->area[19]->impatto. "\r\n");
//$sir_str_2_1_2=("#cfr rischio #idraulico #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[1]->area[19]->impatto. "\r\n");
//$sir_str_2_2=("#cfr rischio #vento #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[2]->area[19]->impatto. "\r\n");
//$sir_str_3_2=("#cfr rischio #mareggiate #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[3]->area[19]->impatto. "\r\n");
//$sir_str_4_2=("#cfr rischio #neve #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[4]->area[19]->impatto. "\r\n");
//$sir_str_5_2=("#cfr rischio #ghiaccio #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[5]->area[19]->impatto. "\r\n");	
//$sir_str_5_1_2=("#cfr rischio #temporali #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[6]->area[19]->impatto. "\r\n");

//Create object
//$data = $sir_str_1_1. $sir_str_2_1_1. $sir_str_2_1. $sir_str_3_1. $sir_str_4_1. $sir_str_5_1. $sir_str_5_1_1;

}
//return $sir_xml;






        
//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml

?>