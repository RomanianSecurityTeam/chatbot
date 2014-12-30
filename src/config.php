<?php
$admin = array(
    "em",
    "shaggi",
    "STiL"
);

$pubfnc = array(
//built-in functions
    "#banlist" => "list_banned",
    "#pm" => "pm",
//custom functions
    "#whois" => "whois",
    "#ping" => "ping",
    "#ip" => "ip",
    "#help" => "help",
    "#host" => "host",
    "#b64" => "b64_function",
    "#encode" => "encode",
    "#short" => "short",
    "#passwd" => "passwd_generate",
    "#weather" => "weather",
    "priv" => "privmsg",
    "#isup" => "isup"
);

$chatevents = array(
    "/login" => "Clogin",
    "/privmsg" => "Cprivmsg"
);

$privfnc = array(
    "#sh" => "sh",
    "#msg" => "message",
    "#ban" => "ban",
    "#unban" => "unban",
    "#die" => "killsw"
);
# Configure chat user and pass


$user = "leet";
$pass = "dummypass";

// init some vars
$userspm = array();
$banned  = array($user);
$priv    = false;
