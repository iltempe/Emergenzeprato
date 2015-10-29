#!/bin/bash
#notifica rischio di oggi da emergenzeprato
#argomenti da passare: tipo rischio e zona
VAR=$(curl -s -G -L 'http://teo-soft.com/emergency/data/risk.xml' | xpath -e '//documento/rischi[@name="oggi"]/rischio[@name="'$1'"]/area[@name="'$2'"]/impatto/text()')
notify-send -u critical -t 10000 -i /home/matteo/meteo.ico 'Rischio '$1'' $VAR
