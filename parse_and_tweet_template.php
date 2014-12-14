<?php

//Parser and tweeter per XML #pratopioggia
//by MT

// require codebird
require_once("codebird-php-develop/src/codebird.php");

date_default_timezone_set('UTC');
$today = date("Ymd");                           // data di oggi
print_r("Oggi è il ".$today);

$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Error: Cannot create object biometeo_ita");
$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Error: Cannot create object biometeo_eng");
$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Error: Cannot create object lamma");
$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks/".$today.".xml") or die("Error: Cannot create object sir");

//data selection for @pratopioggia

$lamma_str=("Previsioni Lamma: " .$lamma_xml->previsione[0]->simbolo[descr]." Temperature min max " .$lamma_xml->previsione[0]->temp[0]. " ".$lamma_xml->previsione[0]->temp[1]);

$biometeo_ita_str=("Previsioni Biometeo: mat " .$biometeo_ita_xml->localita->AA_des_m_oggi. " pom " .$biometeo_ita_xml->localita->AA_des_p_oggi. " sera " .$biometeo_ita_xml->localita->AA_des_s_oggi);

$biometeo_eng_str=("Forecast Biometeo: mor " .$biometeo_eng_xml->localita->AA_des_m_oggi. " aft " .$biometeo_eng_xml->localita->AA_des_p_oggi. " eve " .$biometeo_eng_xml->localita->AA_des_s_oggi);

//In zona B2
$sir_str_1_1=("Rischio idrogeologico-idraulico Comune di Prato (B2): " .$sir_xml->rischi->rischio[0]->area[5]->impatto);
print_r($sir_str_1_1);

$sir_str_2_1=("Rischio vento Comune di Prato (B2): " .$sir_xml->rischi->rischio[1]->area[5]->impatto);
print_r($sir_str_2_1);

$sir_str_3_1=("Rischio mareggiate Comune di Prato (B2): " .$sir_xml->rischi->rischio[2]->area[5]->impatto);
print_r($sir_str_3_1);

$sir_str_4_1=("Rischio neve Comune di Prato (B2): " .$sir_xml->rischi->rischio[3]->area[5]->impatto);
print_r($sir_str_4_1);

$sir_str_5_1=("Rischio ghiaccio Comune di Prato (B2): " .$sir_xml->rischi->rischio[4]->area[5]->impatto);
print_r($sir_str_5_1);

//In zona B3
$sir_str_1_2=("Rischio idrogeologico-idraulico Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[0]->area[6]->impatto);
print_r($sir_str_1_2);

$sir_str_2_2=("Rischio vento Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[1]->area[6]->impatto);
print_r($sir_str_2_2);

$sir_str_3_2=("Rischio mareggiate Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[2]->area[6]->impatto);
print_r($sir_str_3_2);

$sir_str_4_2=("Rischio neve Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[3]->area[6]->impatto);
print_r($sir_str_4_2);

$sir_str_5_2=("Rischio ghiaccio Comuni di Prato Carmignano Montemurlo Poggio a Caiano Vaiano Vernio (B3): " .$sir_xml->rischi->rischio[4]->area[6]->impatto);
print_r($sir_str_5_2);

//In zona B5
$sir_str_1_3=("Rischio idrogeologico-idraulico Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[0]->area[8]->impatto);
print_r($sir_str_1_3);

$sir_str_2_3=("Rischio vento Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[1]->area[8]->impatto);
print_r($sir_str_2_3);

$sir_str_3_3=("Rischio mareggiate Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[2]->area[8]->impatto);
print_r($sir_str_3_3);

$sir_str_4_3=("Rischio neve Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[3]->area[8]->impatto);
print_r($sir_str_4_3);

$sir_str_5_3=("Rischio ghiaccio Comuni di Vernio Cantagallo (B5): " .$sir_xml->rischi->rischio[4]->area[8]->impatto);
print_r($sir_str_5_3);

// twitter part autenticazione.
\Codebird\Codebird::setConsumerKey("------------", "------------");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("------------", "--------------");
 
$params = array(
  'status' => $lamma_str
);
$reply = $cb->statuses_update($params);

sleep(60);

$params = array(
  'status' => $biometeo_ita_str
);
$reply = $cb->statuses_update($params);

sleep(60);

$params = array(
  'status' => $biometeo_eng_str
);
$reply = $cb->statuses_update($params);

sleep(60);

/////

$params = array(
  'status' => $sir_str_1_1
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_2_1
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_3_1
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_4_1
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_5_1
);
$reply = $cb->statuses_update($params);

sleep(60);



////

$params = array(
  'status' => $sir_str_1_2
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_2_2
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_3_2
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_4_2
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_5_2
);
$reply = $cb->statuses_update($params);

sleep(60);



////

$params = array(
  'status' => $sir_str_1_3
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_2_3
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_3_3
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_4_3
);
$reply = $cb->statuses_update($params);

sleep(60);


$params = array(
  'status' => $sir_str_5_3
);
$reply = $cb->statuses_update($params);


//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml
//http://data.biometeo.it/PRATO/PRATO_ENGuale.xml.xml
//http://www.sir.toscana.it/supports/xml/risks/20141202.xml

?>