<?php
$admin = array("em","shaggi","STiL");

$pubfnc = array("#whois" => "whois",
				"#ping"=>"ping", 
				"#ip"=>"ip", 
				"#help"=>"help",
				"#host"=>"host", 
				"#b64"=>"b64_function", 
				"#encode"=>"encode",
				"#short"=>"short", 
				"#passwd" =>"passwd_generate", 
				"#banlist" =>"list_banned", 
				"#pm"=>"pm",
				"#weather"=>"weather",
				"#isup"=>"isup");
				
$chatevents = array("/login"=>"Clogin",
				"/privmsg"=>"privmsg");
				
$privfnc = array("#sh"=>"sh",
				"#msg"=>"msg", 
				"#ban"=>"ban", 
				"#unban"=>"unban",
				"#die"=>"killsw");
# Configure chat user and pass


$user = "leet";
$pass = "dummypass";


$userspm = array();
$banned = array($user);
$priv = false;
?>
