#!/usr/bin/php
<?php
//previsto da chiamare solo php start.php con 1 eventuale parametro che può essere
	//hookset per settare il link di webhook
	//hookremove per rimuovere il link di webhook
	//getupdates per eseguzione a polling (con cron o manualmente)
//e non si imposta il primo paramentro da shell si assume di avere impostato il webhook e di utilizzare quello

include(dirname(__FILE__).'/../settings.php');
include('settings_t.php');
include("emergenzeprato.php");
include('getUpdates.php');


	//istanzia oggetto Telegram
	$bot_id = TELEGRAM_BOT;
	$bot = new Telegram($bot_id);

//valuta se l'interfaccia è di tipo CLI per vedere il parametro e settare o rimuovere il webhook e poi esce (se lanciato da riga di comando) 
if (php_sapi_name() == 'cli') {
  if ($argv[1] == 'sethook') {
  	//setta il webhook
    $bot->setWebhook(BOT_WEBHOOK);
  } else if ($argv[1] == 'removehook') {
  	//rimuove il webhook
    $bot->removeWebhook();
  }else if ($argv[1] == 'getupdates') {
  	//esegue il getupdates manuale
	getUpdates($bot);
   }
  exit;
}

//inizializzo il bot
$bot->init();

// Instances the class for data
$db = new PDO(DB_NAME);
$data=new getdata();
$update_manager= new emergenzeprato();

//gestione invio allerte in broadcast da commentare se si vuole disabilitare le allerte in broadcast. 
//Per ora (in fase di testing) è attivo l'invio dell'allerta su aggiornamento del sito della protezione civile. 
broadcast_manager($db,$bot,$data);

//legge e risponde
$update = $bot->getData();
$update_manager->start($bot,$db,$update,$data);

