Emergenzeprato data manager
===========================

Gestore fonti e dati per il progetto @emergenzeprato

Alcune fonti sono dati aperti della regione Toscana.

---------
TWITTER

Gli script per inviare i tweet vanno eseguiti con la periodicità con cui si vuole tuittare le informazioni, è possibile creare secondo lo stesso approccio tanti script quanti se ne vogliono.

Si preleva i dati delle fonti Lamma, Biometeo e CFR Toscana e si tuittano i dati su @emergenzeprato

L'account @emergenzeprato rituitta tutti i tweet con tag ben precisi e le foto Instagram #pratopioggia

Inoltre tutti i tweet taggati con un ht definito e geolocalizzazione vengono mappati su pratosmart.org

----------
TELEGRAM

Aggiunto anche Telegram bot (sviluppato a partire da https://github.com/Eleirbag89/TelegramBotPHP). 
- Creare un bot su Telegram 
- definire i comandi da inviare e gestire con getUpdates.php
- definire come prelevare i dati con getdata.php
- Creare un Cron Job per eseguire getUpadates.php ad intervalli di tempo regolari (per emergenzeprato è eseguito ogni minuto).

Per usare Emergenzeprato su Telegram:
- aggiungere  @emergenzeprato_bot su Telegram
- inviare a emergenzeprato i comandi per ricevere gli aggiornamenti come indicato qui http://pratosmart.teo-soft.com/emergenzeprato-cresce-telegram-per-sapere-il-meteo-a-prato/

--------
GESTIONE DEI JOB
Un esempio di come va strutturata la tabella dei CRON per schedulare i task.

* * * * * php /home/pi/emergenzeprato/TelegramBot/getUpdates.php 

00  00-16 * * * cd /home/pi/emergenzeprato && php storage.php

00 09,10 * * * cd /home/pi/emergenzeprato/TwitterBot && php tweet_meteo.php "oggi" 

00 07,12,16,00 * * * cd /home/pi/emergenzeprato/TwitterBot && php tweet_temperature.php 

etc...

---------
SOCIAL NETWORK

Se si vuole integrare con regole sui social network può essere usato IFTTT come usato qui
https://ifttt.com/p/pratopioggia/shared

--------
INFORMAZIONI

Per info pratosmart.org

Qui la presentazione del progetto
http://pratosmart.teo-soft.com/emergenzeprato/

https://docs.google.com/presentation/d/1yeZxMVFpiL8zfhG52U2zi8MRjWqDWiptkiPIeef9ntg/pub?start=false&loop=false&delayms=3000 (CC-BY-SA)

