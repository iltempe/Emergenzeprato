Emergenzeprato data manager
===========================

Parser fonti XML per il progetto @emergenzeprato

Le fonti sono dati aperti della regione Toscana e sono elencate al termine del file.

Gli script "parse_and_tweet.php" e "parse_and_tweet_risk.php" vanno eseguiti con la periodicità con cui si vuole tuittare le informazioni, è possibile creare secondo lo stesso approccio tanti script quanti se ne vogliono.

Si preleva i dati delle fonti Lamma, Biometeo e CFR Toscana e si tuittano i dati su @emergenzeprato

L'account @emergenzeprato rituitta tutti i tweet con tag ben precisi e le foto Instagram #pratopioggia

Inoltre tutti i tweet taggati #pratopioggia con localizzazione vengono mappati su pratosmart.org

Per info pratosmart.org

Qui la presentazione del progetto
http://pratosmart.teo-soft.com/emergenzeprato/

https://docs.google.com/presentation/d/1yeZxMVFpiL8zfhG52U2zi8MRjWqDWiptkiPIeef9ntg/pub?start=false&loop=false&delayms=3000 (CC-BY-SA)
----------

Aggiunto anche Telegram bot (sviluppato a partire da https://github.com/Eleirbag89/TelegramBotPHP). 
- Creare un bot su Telegram 
- definire i comandi da inviare e gestire con getUpdates.php
- definire come prelevare i dati con getdata.php
- Creare un Cron Job per eseguire getUpadates.php ad intervalli di tempo regolari (per emergenzeprato è eseguito ogni minuto).

Per usare Emergenzeprato su Telegram:
- aggiungere  @emergenzeprato_bot su Telegram
- inviare a emergenzeprato la parola "meteo" o "previsioni" per ricevere rispettivamente il meteo e il biometeo del giorno o del giorno dopo.



