<?php

//send audio file to raspberryPI audio oputput
//by MT 

//to setup audio on analog audio in raspPI make this command
//amixer cset numid=3 1
//to play a file
//omxplayer example.mp3 OR 
//omxplayer -o local example.mp3



//$audio_file is the complete path of file audio in your raspberry
function audio_play($audio_file){

	exec('/usr/bin/sudo /usr/bin/omxplayer '. $audio_file);

}


?>
