Emergenzeprato Bot for IOT 
(to use a megaphone connected to a RaspPI that use getting.php file to read opendata of risk and weather
==============

- Setup audio analog source on RaspPI with "amixer cset numid=3 1" in ssh connection
- Test audio source with command "omxplayer example.mp3"
- using cron job with alert_risk.php

remembert to delete alarm.txt file every time you want reset the alarm 
