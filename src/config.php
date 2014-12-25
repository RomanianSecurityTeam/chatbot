<?php
$admin = array("em","shaggi","STiL");

$pubfnc = array("whois" => "whois",
				"ping"=>"ping", 
				"ip"=>"ip", 
				"host"=>"host", 
				"b64_encode"=>"b64_encode", 
				"b64_decode"=>"b64_decode", 
				"md5_encode"=>"md5_encode", 
				"sha1_encode"=>"sha1_encode", 
				"short"=>"short", 
				"passwd_generate" =>"passwd_generate", 
				"_banned" =>"list_banned", 
				"_pm"=>"pm");
				
$chatevents = array("/login"=>"Clogin",
				"/privmsg"=>"privmsg");
				
$privfnc = array("sh"=>"sh",
				"msg"=>"msg", 
				"_ban"=>"ban", 
				"_unban"=>"unban");
# Configure chat user and pass

$user = "leet";
$pass = "dummypass";

$userspm = array();
$banned = array($user);
$priv = false;
?>
