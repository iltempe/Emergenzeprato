<?php

//Wrapper delle fonti #emergenzeprato e preparazione dati di interesse per i vari bot
//questa classe deve essere istanziata nei vari JOB che vogliono usare i dati
//by MT 

const PROT_CIV = 'http://page2rss.com/rss/28dbb41c5e425167e4d73bf1b00dd7cd';
require_once __DIR__.'/./HTMLscraper/src/ScraperInterface.php';
require_once __DIR__.'/./HTMLscraper/src/Scraper.php';


class getdata {


//legge i dati dal biometeo in italiano
private function get_biometeo_ita() {

	//biometeo
	//remote
	//$biometeo_ita_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");
	//local
	$biometeo_ita_xml=simplexml_load_file(dirname(__FILE__). "/data/biometeo_ITA.xml") or die("Errore nella ricerca del file relativo al biometeo ITA");
	return $biometeo_ita_xml;

}

//legge i dati del biometeo in inglese
private function get_biometeo_eng() {

	//biometeo
	//$biometeo_eng_xml=simplexml_load_file("http://data.biometeo.it/PRATO/PRATO_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");
	$biometeo_eng_xml=simplexml_load_file(dirname(__FILE__). "/data/biometeo_ENG.xml") or die("Errore nella ricerca del file relativo al biometeo ENG");
	return $biometeo_eng_xml;
}

//legge i dati lamma meteo
private function get_lamma() {

	//lamma opentoscana
	//$lamma_xml=simplexml_load_file("http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");
	$lamma_xml=simplexml_load_file(dirname(__FILE__). "/data/meteo.xml") or die("Errore nella ricerca del file relativo alla previsione LAMMA");
	return $lamma_xml;

}

//legge i dati del rischio
private function get_risk() {

date_default_timezone_set('UTC');
$today = date("Ymd");   

//Gestione Rischio Centro Funzionale Regione Toscana
//$sir_xml=simplexml_load_file("http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"); 
$sir_xml=simplexml_load_file(dirname(__FILE__). "/data/risk.xml"); 

if ($sir_xml==false)
	{
		print("Errore nella ricerca del file relativo al rischio");
	}

return $sir_xml;

}


//seleziona un dato del biometeo specificando se si tratta di oggi/domani, mattina/pomeriggio/sera e la lingua ita/eng
public function select_biometeo_data($today, $when, $lang){

	if($lang=="ita")
	{
	 $xml_file=$this->get_biometeo_ita();
	}
	else
	{
	 $xml_file=$this->get_biometeo_eng();
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

 $xml_file=$this->get_lamma();
 
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

return $data;


}

//seleziona un dato dai rischi specificando se oggi/domani, la zona B/R e il tipo di rischio
public function select_risk_data($when, $zone, $type){
	$xml_file=$this->get_risk();
	if($xml_file)
	{
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
	}
	else
	{
		$data="";
	}
 
 return $data;

}

//prepara la stringa per il meteo di oggi/domani
public function lamma_text($today) {

//string setting
$lamma_str=($this->select_meteo_data($today,"-")." min " .$this->select_meteo_data($today,"min"). " max " .$this->select_meteo_data($today,"max") ."\r\n");

return $lamma_str;

}

//prepara la stringa per il biometeo di oggi/domani
public function biometeo_ita_text($today){

	$biometeo_ita_str=("mat " .$this->select_biometeo_data($today,"mattina","ita"). " pom " .$this->select_biometeo_data($today,"pomeriggio","ita"). " sera " .$this->select_biometeo_data($today,"sera","ita"));
	$biometeo = $biometeo_ita_str;
	return $biometeo;
}

//prepara la stringa per il biometeo di oggi/domani
public function biometeo_eng_text($today){

	$biometeo_eng_str=("mor " .$this->select_biometeo_data($today,"mattina","eng"). " aft " .$this->select_biometeo_data($today,"pomeriggio","eng"). " eve " .$this->select_biometeo_data($today,"sera","eng"));
	$biometeo = $biometeo_eng_str;
	return $biometeo;
}

//prepara la stringa per il biometeo di oggi/domani
public function biometeo_text($today){

	$biometeo_ita_str=$this->biometeo_ita_text($today);
	$biometeo_eng_str=$this->biometeo_eng_text($today);
	$biometeo = $biometeo_ita_str. "\r\n" .$biometeo_eng_str;
	return $biometeo;
}


//prepara la stringa dei rischi di oggi/domani in base alla zona B/R
public function risk_text($today,$zone)
{
	//verifica se il file è vuoto
	if($this->select_risk_data($today,$zone,"idrogeologico"))
	{
			if($zone=="B")
			{
				$sir_str_1=("Rischio idrogeologico a Prato: " .$this->select_risk_data($today,"B","idrogeologico"). "\r\n");
				$sir_str_2=("Rischio idraulico a Prato: " .$this->select_risk_data($today,"B","idraulico"). "\r\n");
				$sir_str_3=("Rischio vento a Prato: " .$this->select_risk_data($today,"B","vento"). "\r\n");
				$sir_str_4=("Rischio mareggiate a Prato: " .$this->select_risk_data($today,"B","mareggiate"). "\r\n");
				$sir_str_5=("Rischio neve a Prato: " .$this->select_risk_data($today,"B","neve"). "\r\n");
				$sir_str_6=("Rischio ghiaccio a Prato: " .$this->select_risk_data($today,"B","ghiaccio"). "\r\n");
				$sir_str_7=("Rischio temporali a Prato: " .$this->select_risk_data($today,"B","temporali"). "\r\n");
			}
			else{
				$sir_str_1=("Rischio idrogeologico a Vernio: " .$this->select_risk_data($today,"R","idrogeologico"). "\r\n");
				$sir_str_2=("Rischio idraulico a Vernio: " .$this->select_risk_data($today,"R","idraulico"). "\r\n");
				$sir_str_3=("Rischio vento a Vernio: " .$this->select_risk_data($today,"R","vento"). "\r\n");
				$sir_str_4=("Rischio mareggiate a Vernio: " .$this->select_risk_data($today,"R","mareggiate"). "\r\n");
				$sir_str_5=("Rischio neve a Vernio: " .$this->select_risk_data($today,"R","neve"). "\r\n");
				$sir_str_6=("Rischio ghiaccio a Vernio: " .$this->select_risk_data($today,"R","ghiaccio"). "\r\n");
				$sir_str_7=("Rischio temporali a Vernio: " .$this->select_risk_data($today,"R","temporali"). "\r\n");
			}
			$sir_str = $sir_str_1. $sir_str_2. $sir_str_3. $sir_str_4. $sir_str_5. $sir_str_6. $sir_str_7;
	}
	else
	{
		$sir_str=null;
	}
	
	return $sir_str;
}

//monitoraggio temperatura
public function get_temperature($where)
{
 switch ($where) {

		//prato
		case "prato est":
		$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:ITOSCANA124.json"); 
		$parsed_json = json_decode($json_string); 
		$location = $parsed_json->{'location'}->{'city'}; 
		$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
		break;

		//carmignano
		case "carmignano":
		$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPRATOTO3.json"); 
		$parsed_json = json_decode($json_string); 
		$location = $parsed_json->{'location'}->{'city'}; 
		$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
		break;

		//vaiano sofignano
		case "vaiano sofignano":
		$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPOVAIAN2.json"); 
		$parsed_json = json_decode($json_string); 
		$location = $parsed_json->{'location'}->{'city'}; 
		$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
		break;

		//vaiano schignano
		case "vaiano schignano":
		$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPRATOVA2.json"); 
		$parsed_json = json_decode($json_string); 
		$location = $parsed_json->{'location'}->{'city'}; 
		$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
		break;

		//montepiano vernio
		case "montepiano vernio":
		$json_string = file_get_contents("http://api.wunderground.com/api/35e826e307f0a35e/conditions/q/pws:IPOMONTE2.json"); 
		$parsed_json = json_decode($json_string); 
		$location = $parsed_json->{'location'}->{'city'}; 
		$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
		break;
}
 return $temp_c;

}  

//definisci il path dell'immagine
public function get_image_path($image)
{
	return "data/". $image. ".jpg";		
}

//preleva ultima allerta del feed protezione civile di Prato o in locale o in remoto e ritorna titolo e data.
public function load_prot($islocal)
{
	date_default_timezone_set('UTC');

	$logfile=(dirname(__FILE__).'/logs/storedata.log');
	
	if($islocal)
	{
		//carico dati salvati in locale per confrontarli con quelli remoti
		$prot_civ=dirname(__FILE__)."/data/prot.xml";
		echo "carico dati in locale";
		print_r($prot_civ);
	}
	else
	{
		//carico dati salvati in remoto
		$prot_civ=PROT_CIV;
		echo "carico dati da remoto";
		print_r($prot_civ);

	}

	$xml_file=simplexml_load_file($prot_civ); 

	if ($xml_file==false)
		{
			print("Errore nella ricerca del file relativo alla protezione civile");
		}
		
		//ritorna il primo elemento del feed rss
		$data[0]=$xml_file->channel->item->title;
		//print_r($data[0]);
		$data[1]=$xml_file->channel->item->pubDate;
		//print_r($data[1]);
		return $data;
}

public function update_prot($data)
{
	$prot_civ=dirname(__FILE__)."/data/prot.xml";

	// load the document
	$info = simplexml_load_file($prot_civ);

	// update
	$info->channel->item->title = $data[0];
	$info->channel->item->pubDate = $data[1];

	// save the updated document
	$info->asXML($prot_civ);

}
//preleva dati protezione civile da sito
public function getting_actual_website_prot()
{
	$object = new Scraper();

	//eseguo lo scrape della pagina
	$html = file_get_contents(PROT_CIV_WEB);

	// seleziono titolo
	$titolo = $object->execute('#head1 h1', $html);	

	//seleziono il contenuto
	$descrizione = $object->execute('#main div div', $html);
	
	$descrizione=implode(" ",$descrizione[1]);
	
	$scraped1=$this->format_scrape($descrizione);
	
	//concateno il ritorno tutto
	$current=$titolo[0]. "\n". $scraped1;
	
	$scraped2[0]=$this->format_scrape($current);
	$scraped2[1]=$scraped1;

	//print_r('SCRAPE--------\n'.$scraped2);
	//print_r('--------------------------');

	//in 1 ritorno il titolo
	//$current[1]=$titolo[0];
	//print_r('TITOLO--------'.$current[1]);
	//print_r('--------------------------');

	//in 2 ritorno la descrizione
	//$current[2]=$descrizione;
	//print_r('ALL-------------'.$current[2]);
	//print_r('--------------------------');

	return $scraped2;
}

public function format_scrape($scrape)
{
	//rimuovo testo inutile
	$testo=str_replace('Numero verde emergenze', '',$scrape);
	$testo=str_replace('800 30 15 30', '',$testo);
	$testo=str_replace('Gallerie  fotografiche', '',$testo);
	$testo=str_replace('Video delle emergenze', '',$testo);
	$testo=str_replace('Meteo a Prato  e dintorni', '',$testo);
	$testo=str_replace('Comportamenti in caso di...', '',$testo);
	$testo = preg_replace('/^[ \t]*[\r\n]+/m', '', $testo);
	
	$find='var mese = ["gennaio","febbraio","marzo","aprile","maggio","giugno","luglio","agosto","settembre","ottobre","novembre","dicembre"];
 var currentDate = new Date();
 var day = currentDate.getDate();
 var month = currentDate.getMonth();
 var hours = currentDate.getHours();
 var minutes = currentDate.getMinutes();
 var year = currentDate.getFullYear();
 document.write(day + " " + mese[month] + " " + year + " ore " + hours + ":" + minutes);

 /* today = new Date(); 
 document.write(today.toLocaleString().substr(0,1).toUpperCase() + today.toLocaleString().substr(1,(today.toLocaleString().length - 9))," ore ",today.toLocaleString().substr(today.toLocaleString().substr(0,(today.toLocaleString().length - 8)).length,5)); */ 
 
 
 
';
$pos = strpos($testo, $find);

if($pos===false)

{
}else
{
	$testo=str_replace($find,'',$testo);
}
return $testo;
}


function array_delete($array, $element) {
    return array_diff($array, [$element]);
}


}      
//Fonti
//http://www.lamma.rete.toscana.it/…/comuni_web/dati/prato.xml
//http://data.biometeo.it/BIOMETEO.xml
//http://data.biometeo.it/PRATO/PRATO_ITA.xml
//http://www.sir.toscana.it/supports/xml/risks_395/".$today.".xml"
//http://www.wunderground.com/weather/api/
//https://github.com/alfcrisci/WU_weather_list/blob/master/WU_stations.csv
?>
