<?php

//Getdata per XML #emergenzeprato e Preparazione testo
//by MT 

class getdata {


//legge i dati dal biometeo in italiano
private function get_biometeo_ita() {

	//biometeo
	$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");

	return $biometeo_ita_xml;

}

//legge i dati del biometeo in inglese
private function get_biometeo_eng() {

	//biometeo
	$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");

	return $biometeo_eng_xml;

}

//legge i dati lamma meteo
private function get_lamma() {

	//lamma opentoscana
	$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");

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
	//$data="Rischi di oggi non ancora disponibili, riprova tra un po' ";
	
}else{}
return $sir_xml;

}


//seleziona un dato del biometeo specificando se si tratta di oggi/domani, mattina/pomeriggio/sera e la lingua ita/eng
public function select_biometeo_data($today, $when, $lang){

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

//seleziona un dato dal lamma specificando oggi/domani e se si tratta di temp max, min o - (previsioni del giorno)
public function select_meteo_data($today,$temp){

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

//seleziona un dato dai rischi specificando se oggi/domani, la zona B/R e il tipo di rischio
public function select_risk_data($when, $zone, $type){
	$xml_file=get_risk();
 	if($when=="oggi")
 	{
		 if($zone=="B")
		 {
			if($type=="idrogeologico")
				{
					$data=$xml_file->rischi[0]->rischio[0]->area[7]->impatto;
				}
			if($type=="idraulico")
				{
						$data=$xml_file->rischi[0]->rischio[1]->area[7]->impatto; 	
				}
			if($type=="vento")
				{
						$data=$xml_file->rischi[0]->rischio[2]->area[7]->impatto;
				}
			if($type=="mareggiate")
				{
						$data=$xml_file->rischi[0]->rischio[3]->area[7]->impatto; 	
				}
			if($type=="neve")
				{
						$data=$xml_file->rischi[0]->rischio[4]->area[7]->impatto;
				}
			if($type=="ghiaccio")
				{
						$data=$xml_file->rischi[0]->rischio[5]->area[7]->impatto;
				}
			if($type=="temporali")
				{
						$data=$xml_file->rischi[0]->rischio[6]->area[7]->impatto;
				}

		 }
		 else{
			if($type=="idrogeologico")
				{
					$data=$xml_file->rischi[0]->rischio[0]->area[19]->impatto;
				}
			if($type=="idraulico")
				{
						$data=$xml_file->rischi[0]->rischio[1]->area[19]->impatto; 	
				}
			if($type=="vento")
				{
						$data=$xml_file->rischi[0]->rischio[2]->area[19]->impatto;
				}
			if($type=="mareggiate")
				{
						$data=$xml_file->rischi[0]->rischio[3]->area[19]->impatto; 	
				}
			if($type=="neve")
				{
						$data=$xml_file->rischi[0]->rischio[4]->area[19]->impatto;
				}
			if($type=="ghiaccio")
				{
						$data=$xml_file->rischi[0]->rischio[5]->area[19]->impatto;
				}
			if($type=="temporali")
				{
						$data=$xml_file->rischi[0]->rischio[6]->area[19]->impatto;
				}
		 }
	}
 	else
 	{
 		if($zone=="B")
		 {
			if($type=="idrogeologico")
				{
					$data=$xml_file->rischi[1]->rischio[0]->area[7]->impatto;
				}
			if($type=="idraulico")
				{
						$data=$xml_file->rischi[1]->rischio[1]->area[7]->impatto; 	
				}
			if($type=="vento")
				{
						$data=$xml_file->rischi[1]->rischio[2]->area[7]->impatto;
				}
			if($type=="mareggiate")
				{
						$data=$xml_file->rischi[1]->rischio[3]->area[7]->impatto; 	
				}
			if($type=="neve")
				{
						$data=$xml_file->rischi[1]->rischio[4]->area[7]->impatto;
				}
			if($type=="ghiaccio")
				{
						$data=$xml_file->rischi[1]->rischio[5]->area[7]->impatto;
				}
			if($type=="temporali")
				{
						$data=$xml_file->rischi[1]->rischio[6]->area[7]->impatto;
				}

		 }
		 else{
			if($type=="idrogeologico")
				{
					$data=$xml_file->rischi[1]->rischio[0]->area[19]->impatto;
				}
			if($type=="idraulico")
				{
						$data=$xml_file->rischi[1]->rischio[1]->area[19]->impatto; 	
				}
			if($type=="vento")
				{
						$data=$xml_file->rischi[1]->rischio[2]->area[19]->impatto;
				}
			if($type=="mareggiate")
				{
						$data=$xml_file->rischi[1]->rischio[3]->area[19]->impatto; 	
				}
			if($type=="neve")
				{
						$data=$xml_file->rischi[1]->rischio[4]->area[19]->impatto;
				}
			if($type=="ghiaccio")
				{
						$data=$xml_file->rischi[1]->rischio[5]->area[19]->impatto;
				}
			if($type=="temporali")
				{
						$data=$xml_file->rischi[1]->rischio[6]->area[19]->impatto;
				}
		 }
	}
 
 return $data;

}

//prepara la stringa per il meteo di oggi/domani
public function lamma_text($today) {

//string setting
$lamma_str=("Meteo per Prato (fonte Lamma): " .select_meteo_data($today,"-")."\r\n minime " .select_meteo_data($today,"min"). "\r\n massime " .select_meteo_data($today,"max"));

return $lamma_str;

}

//prepara la stringa per il biometeo di oggi/domani
public function biometeo_text($today){

	$biometeo_ita_str=("\r\nBiometeo per Prato: mattina " .select_biometeo_data($today,"mattina","ita"). "\r\n pomeriggio " .select_biometeo_data($today,"pomeriggio","ita"). "\r\n sera " .select_biometeo_data($today,"sera","ita"));
	$biometeo_eng_str=("\r\nBiometeo for Prato: morning " .select_biometeo_data($today,"mattina","eng"). "\r\n afternoon " .select_biometeo_data($today,"pomeriggio","eng"). "\r\n evening " .select_biometeo_data($today,"sera","eng"));
	$biometeo = $biometeo_ita_str. " " .$biometeo_eng_str;
	return $biometeo;
}

//prepara la stringa dei rischi di oggi/domani in base alla zona B/R
public function risk_text($zone,$today)
{
	if($zone=="B")
	{
	$sir_str_1=("Rischio idrogeologico a Prato: " .select_risk_data($today,"B","idrogeologico"). "\r\n");
	$sir_str_2=("Rischio idraulico a Prato: " .select_risk_data($today,"B","idraulico"). "\r\n");
	$sir_str_3=("Rischio vento a Prato: " .select_risk_data($today,"B","vento"). "\r\n");
	$sir_str_4=("Rischio mareggiate a Prato: " .select_risk_data($today,"B","mareggiate"). "\r\n");
	$sir_str_5=("Rischio neve a Prato: " .select_risk_data($today,"B","neve"). "\r\n");
	$sir_str_6=("Rischio ghiaccio a Prato: " .select_risk_data($today,"B","ghiaccio"). "\r\n");
	$sir_str_7=("Rischio temporali a Prato: " .select_risk_data($today,"B","temporali"). "\r\n");
	}
	else{
	$sir_str_1=("Rischio idrogeologico a Vernio: " .select_risk_data($today,"R","idrogeologico"). "\r\n");
	$sir_str_2=("Rischio idraulico a Vernio: " .select_risk_data($today,"R","idraulico"). "\r\n");
	$sir_str_3=("Rischio vento a Vernio: " .select_risk_data($today,"R","vento"). "\r\n");
	$sir_str_4=("Rischio mareggiate a Vernio: " .select_risk_data($today,"R","mareggiate"). "\r\n");
	$sir_str_5=("Rischio neve a Vernio: " .select_risk_data($today,"R","neve"). "\r\n");
	$sir_str_6=("Rischio ghiaccio a Vernio: " .select_risk_data($today,"R","ghiaccio"). "\r\n");
	$sir_str_7=("Rischio temporali a Vernio: " .select_risk_data($today,"R","temporali"). "\r\n");
	}
	
	$sir_str = $sir_str_1. $sir_str_2. $sir_str_3. $sir_str_4. $sir_str_5. $sir_str_6. $sir_str_7;
	
	return $sir_str;

}

        
//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml

?>
