
In localhost is possible to launch
php start.php 'sethook' to set start.php as webhook
php start.php 'removehook' to remove start.php as webhook
php start.php 'getupdates' to run getupdates.php

After setup webhook is possible to use telegram managed by webhost

Remember to create a sqlite database with tables specified in settings_t.php file (using admin_db.php). DB will be used to log and to make broadcast sending
this DB shall be composed by at least 2 tables (log for logging and user for broadcast messaging).


