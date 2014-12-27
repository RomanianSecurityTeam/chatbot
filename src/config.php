<?php
$admin = array("em","shaggi","STiL");

$pubfnc = array("#whois" => "whois",
				"#ping"=>"ping", 
				"#ip"=>"ip", 
				"#host"=>"host", 
				"#b64"=>"b64_function", 
				"#encode"=>"encode",
				"short"=>"short", 
				"#passwd" =>"passwd_generate", 
				"#banned" =>"list_banned", 
				"#pm"=>"pm");
				
$chatevents = array("/login"=>"Clogin",
				"/privmsg"=>"privmsg");
				
$privfnc = array("sh"=>"sh",
				"#msg"=>"msg", 
				"#ban"=>"ban", 
				"#unban"=>"unban");
# Configure chat user and pass


$user = "leet";
$pass = "dummypass";


$userspm = array();
$banned = array($user);
$priv = false;
?>
