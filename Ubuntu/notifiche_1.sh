#put correct link in this command
wget http://./././protezione_civile.txt
notify-send -u critical -t 10000 -i /home/matteo/meteo.ico 'Emergenzeprato' "$(tail protezione_civile.txt)"
rm protezione_civile.txt
chromium-browser "http://www.protezionecivile.comune.prato.it/emergenze/"

