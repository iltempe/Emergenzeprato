<?php
//modulo delle KEYs per funzionamento dei bot (da non committare)

//Telegram
define('TELEGRAM_BOT','133208917:AAFW2zvL_ubXP7Hs23W-WODeEhGnpod8xXI');
define('BOT_WEBHOOK', 'https://teo-soft.com/emergency/TelegramBot/start.php');
define('LOG_FILE', 'telegram.log');

// Your database
$db_path=dirname(__FILE__).'/./emergenzeprato.sqlite';
define ('DB_NAME', "sqlite:". $db_path);
define('DB_TABLE',"user");
define('DB_TABLE_GEO',"segnalazioni");
define('DB_CONF', 0666);
define('DB_ERR', "errore database SQLITE");


?>
