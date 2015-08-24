<?php

//Getdata per XML #emergenzeprato
//by MT 

class getdata {

//legge i dati dal biometeo in italiano
private function get_biometeo_ita() {

//biometeo
$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");

//lamma opentoscana
//$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//data parsing for @emergenzeprato
//$lamma_str=("Previsioni Meteo di oggi per Prato (Lamma): " .$lamma_xml->previsione[0]->simbolo[descr]."\r\n min " .$lamma_xml->previsione[0]->temp[0]. "\r\n max " .$lamma_xml->previsione[0]->temp[1]);
//$biometeo_ita_str=("\r\nPrevisioni Biometeo di oggi per Prato: mattino " .$biometeo_ita_xml->localita->AA_des_m_oggi. "\r\n pomeriggio " .$biometeo_ita_xml->localita->AA_des_p_oggi. "\r\n sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);
//$biometeo_eng_str=("\r\nForecast Biometeo for Prato: morning " .$biometeo_eng_xml->localita->AA_des_m_oggi. "\r\n afternoon " .$biometeo_eng_xml->localita->AA_des_p_oggi. "\r\n evening " .$biometeo_eng_xml->localita->AA_des_s_oggi);

// Set status message
//$data = $lamma_str. " " .$biometeo_ita_str. " " .$biometeo_eng_str;
//print_r($data);

return $biometeo_ita_xml;

}

//legge i dati del biometeo in inglese
private function get_biometeo_eng() {

//biometeo
$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");

//lamma opentoscana
//$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//data parsing for @emergenzeprato
//$lamma_str=("Previsioni Meteo di oggi per Prato (Lamma): " .$lamma_xml->previsione[0]->simbolo[descr]."\r\n min " .$lamma_xml->previsione[0]->temp[0]. "\r\n max " .$lamma_xml->previsione[0]->temp[1]);
//$biometeo_ita_str=("\r\nPrevisioni Biometeo di oggi per Prato: mattino " .$biometeo_ita_xml->localita->AA_des_m_oggi. "\r\n pomeriggio " .$biometeo_ita_xml->localita->AA_des_p_oggi. "\r\n sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);
//$biometeo_eng_str=("\r\nForecast Biometeo for Prato: morning " .$biometeo_eng_xml->localita->AA_des_m_oggi. "\r\n afternoon " .$biometeo_eng_xml->localita->AA_des_p_oggi. "\r\n evening " .$biometeo_eng_xml->localita->AA_des_s_oggi);

// Set status message
//$data = $lamma_str. " " .$biometeo_ita_str. " " .$biometeo_eng_str;
//print_r($data);

return $biometeo_eng_xml;

}

//legge i dati lamma meteo
private function get_lamma() {

//lamma opentoscana
$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//data parsing for @emergenzeprato
//$lamma_str=("Previsioni Meteo di oggi per Prato (Lamma): " .$lamma_xml->previsione[0]->simbolo[descr]."\r\n min " .$lamma_xml->previsione[0]->temp[0]. "\r\n max " .$lamma_xml->previsione[0]->temp[1]);
//$biometeo_ita_str=("\r\nPrevisioni Biometeo di oggi per Prato: mattino " .$biometeo_ita_xml->localita->AA_des_m_oggi. "\r\n pomeriggio " .$biometeo_ita_xml->localita->AA_des_p_oggi. "\r\n sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);
//$biometeo_eng_str=("\r\nForecast Biometeo for Prato: morning " .$biometeo_eng_xml->localita->AA_des_m_oggi. "\r\n afternoon " .$biometeo_eng_xml->localita->AA_des_p_oggi. "\r\n evening " .$biometeo_eng_xml->localita->AA_des_s_oggi);

// Set status message
//$data = $lamma_str. " " .$biometeo_ita_str. " " .$biometeo_eng_str;
//print_r($data);

return $lamma_xml;

}

//legge i dati del rischio
private function get_risk() {

date_default_timezone_set('UTC');
$today = date("Ymd");   

//Gestione Rischio Centro Funzionale Regione Toscana
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"); 

if ($sir_xml==false)
	{
	print("Errore nella ricerca del file relativo al rischio");
	$data="Rischi di oggi non ancora disponibili, riprova tra un po' ";
	
}else{

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
return $sir_xml;

}

//preleva un dato del biometeo specificando se si tratta di oggi/domani, mattina/pomeriggio/sera e la lingua ita/eng
public get_biometeo_data($today, $when, $lang){

if($lang=="ita")
{
 $xml_file=get_biometeo_ita();
}
else
{
 $xml_file=get_biometeo_eng();
}

if($today=="oggi")
{
 if($when="mattina"){
  $data=$xml_file->localita->AA_des_m_oggi;
 }
 if($when="pomeriggio"){
  $data=$xml_file->localita->AA_des_p_oggi;
 }
 if($when="sera"){
  $data=$xml_file->localita->AA_des_s_oggi;
 }
}
else{
 if($when="mattina"){
  $data=$xml_file->localita->AA_des_m_domani;
 }
 if($when="pomeriggio"){
  $data=$xml_file->localita->AA_des_p_domani;
 }
 if($when="sera"){
  $data=$xml_file->localita->AA_des_s_domani;
 }
}
return $data;

}

//preleva un dato dal lamma specificando oggi/domani e se si tratta di temp max, min o - (previsioni del giorno)
public get_meteo_data($today,$temp){

 $xml_file=get_lamma();
 
 if($today=="oggi"){
 
 	if($temp=="min")
 	{
 	    $data=$xml_file->previsione[0]->temp[0];
 	}
 	if($temp=="-")
 	{
 	 	$data=$xml_file->previsione[0]->simbolo[descr];	
 	}
 	if($temp=="max")
 	{
 	 	$data=$xml_file->previsione[0]->temp[1];
 	}
 
 }
 else{
 
  	if($temp=="min")
 	{
 	    $data=$xml_file->previsione[4]->temp[0];
 	}
 	if($temp=="-")
 	{
 	 	$data=$xml_file->previsione[4]->simbolo[descr];	
 	}
 	if($temp=="max")
 	{
 	 	$data=$xml_file->previsione[4]->temp[1];
 	}
 }



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
}

        
//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml

?>