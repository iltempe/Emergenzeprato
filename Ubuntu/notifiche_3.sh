#!/bin/bash
#notifica rischio di oggi da emergenzeprato
#parametri giorno e ora
#put correct link in this command
VAR=$(curl -s -G -L 'http://./././meteo.xml' | xpath -e '//dati/previsione[@idday="'$1'" and @ora="'$2'"]/simbolo/@descr' | sed "s/.* descr=\"\(.*\)\".*/\1/")
VAR1=$(echo $VAR)
notify-send -u critical -t 5000 -i /home/matteo/meteo.ico 'Previsioni Meteo' $VAR1
