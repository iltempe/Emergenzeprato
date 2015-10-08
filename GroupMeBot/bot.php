<?php
 
  // SET THIS FILE'S URL AS YOUR BOT'S CALLBACK
  
  require 'groupMeApi.php'; // functions for the bot to use
  require 'settings_g.php';
  


function groupme_send($text)
{
  
  $groupId = GROUP_ID;  
  $botId   = BOT_ID;
  
  $groupMe = new groupMeApi();
  
  $groupMe->botPost($groupId,$botId,$text); 
 }
  
?>  