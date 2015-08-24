<?php

//Getdata per XML #emergenzaprato telegrambot
//by MT 

class getdata {


public function getdata() {

//biometeo
$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");
$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");

//lamma opentoscana
$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//data parsing for @emergenzeprato
$lamma_str=("Previsioni Meteo di oggi per Prato (Lamma): " .$lamma_xml->previsione[0]->simbolo[descr]."\r\n min " .$lamma_xml->previsione[0]->temp[0]. "\r\n max " .$lamma_xml->previsione[0]->temp[1]);
$biometeo_ita_str=("\r\nPrevisioni Biometeo di oggi per Prato: mattino " .$biometeo_ita_xml->localita->AA_des_m_oggi. "\r\n pomeriggio " .$biometeo_ita_xml->localita->AA_des_p_oggi. "\r\n sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);
$biometeo_eng_str=("\r\nForecast Biometeo for Prato: morning " .$biometeo_eng_xml->localita->AA_des_m_oggi. "\r\n afternoon " .$biometeo_eng_xml->localita->AA_des_p_oggi. "\r\n evening " .$biometeo_eng_xml->localita->AA_des_s_oggi);

// Set status message
$data = $lamma_str. " " .$biometeo_ita_str. " " .$biometeo_eng_str;
//print_r($data);

return $data;

}

public function getdata_tomorrow() {

//biometeo
$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");
$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");

//lamma opentoscana
$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//XML data parsing for @pratopioggia
$lamma_str=("Previsioni Meteo per domani a Prato (Lamma): " .$lamma_xml->previsione[4]->simbolo[descr]."\r\n Temperature min " .$lamma_xml->previsione[4]->temp[0]. "\r\n max " .$lamma_xml->previsione[4]->temp[1]);

$biometeo_ita_str=("\r\nPrevisioni domani dal Biometeo per Prato: mattino " .$biometeo_ita_xml->localita->AA_des_m_domani. "\r\n pomeriggio " .$biometeo_ita_xml->localita->AA_des_p_domani. "\r\n sera " .$biometeo_ita_xml->localita->AA_des_s_domani);
$biometeo_eng_str=("\r\nForecast for tomorrow from Biometeo Prato: morning " .$biometeo_eng_xml->localita->AA_des_m_domani. "\r\n afternoon " .$biometeo_eng_xml->localita->AA_des_p_domani. "\r\n evening " .$biometeo_eng_xml->localita->AA_des_s_domani);

// Set status message
$data = $lamma_str. " " .$biometeo_ita_str. " " .$biometeo_eng_str;

return $data;

}


public function getdata_risk() {

date_default_timezone_set('UTC');
$today = date("Ymd");   

//Gestione Rischio Regione Toscana
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"); 

if ($sir_xml==false)
	{
	print("Errore nella ricerca del file relativo al rischio");
	$data="Rischi di oggi non ancora disponibili, riprova tra un po' ";
	
}else{

//In zona B
$sir_str_1_1=("Rischio idrogeologico a Prato: " .$sir_xml->rischi->rischio[0]->area[7]->impatto. "\r\n");

$sir_str_2_1_1=("Rischio idraulico a Prato: " .$sir_xml->rischi->rischio[1]->area[7]->impatto. "\r\n");

$sir_str_2_1=("Rischio vento a Prato: " .$sir_xml->rischi->rischio[2]->area[7]->impatto. "\r\n");

$sir_str_3_1=("Rischio mareggiate a Prato: " .$sir_xml->rischi->rischio[3]->area[7]->impatto. "\r\n");

$sir_str_4_1=("Rischio neve a Prato: " .$sir_xml->rischi->rischio[4]->area[7]->impatto. "\r\n");

$sir_str_5_1=("Rischio ghiaccio a Prato: " .$sir_xml->rischi->rischio[5]->area[7]->impatto. "\r\n");
	
$sir_str_5_1_1=("Rischio temporali a Prato: " .$sir_xml->rischi->rischio[6]->area[7]->impatto. "\r\n");

//In zona R1
//$sir_str_1_2=("#cfr rischio #idrogeologico #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[0]->area[19]->impatto. "\r\n");

//$sir_str_2_1_2=("#cfr rischio #idraulico #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[1]->area[19]->impatto. "\r\n");

//$sir_str_2_2=("#cfr rischio #vento #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[2]->area[19]->impatto. "\r\n");

//$sir_str_3_2=("#cfr rischio #mareggiate #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[3]->area[19]->impatto. "\r\n");

//$sir_str_4_2=("#cfr rischio #neve #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[4]->area[19]->impatto. "\r\n");

//$sir_str_5_2=("#cfr rischio #ghiaccio #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[5]->area[19]->impatto. "\r\n");
	
//$sir_str_5_1_2=("#cfr rischio #temporali #allertameteoTOS #Vernio: " .$sir_xml->rischi->rischio[6]->area[19]->impatto. "\r\n");


// Create object
$data = $sir_str_1_1. $sir_str_2_1_1. $sir_str_2_1. $sir_str_3_1. $sir_str_4_1. $sir_str_5_1. $sir_str_5_1_1;

}
return $data;

}
}
        
//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml

?>