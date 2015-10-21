Emergenzeprato Google Calendar Bot
==============
This bot update a Google Calendar with weather forecast and risk derived from opendata of Tuscany.

- Create a Public Google Calendar
- Follow this indication to register an official web app on google console https://developers.google.com/google-apps/calendar/quickstart/php (step 1)
- Put the file of the app json in the same folder of calendar.php
- For the first time you have to autorize the app executing calendar.php from shell, copy the code in address browser and and produce a client secret json file (put in the same folder)
- you can now schedule a cron curl -sleep http://yourfolder/calendar.php?what=rischio 
