<?php

//Getdata per XML #emergenzaprato telegrambot
//by MT

class getdata {
	public function getdata() {

date_default_timezone_set('UTC');
$today = date("Ymd");                           // data di oggi
print_r("Oggi è il ".$today);

//biometeo
$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");
$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");

//lamma opentoscana
$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

//data parsing for @emergenzeprato
$lamma_str=("Previsioni Meteo Lamma di oggi per Prato: " .$lamma_xml->previsione[0]->simbolo[descr]." Temperature minime " .$lamma_xml->previsione[0]->temp[0]. " massime " .$lamma_xml->previsione[0]->temp[1]);
$biometeo_ita_str=(" Previsioni Biometeo di oggi per Prato: mattino " .$biometeo_ita_xml->localita->AA_des_m_oggi. " pomeriggio " .$biometeo_ita_xml->localita->AA_des_p_oggi. " sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);
$biometeo_eng_str=(" Forecast Biometeo for Prato: morning " .$biometeo_eng_xml->localita->AA_des_m_oggi. " afternoon " .$biometeo_eng_xml->localita->AA_des_p_oggi. " evening " .$biometeo_eng_xml->localita->AA_des_s_oggi);

print_r($data);
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