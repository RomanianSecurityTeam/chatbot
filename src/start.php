<?php
include("functions.php");
include("chat.inc.php");
include("custom.php");
include("config.php");

login($user, $pass);

$raw = getraw($user);

if (banned($raw)) {
    die("banned");
}

$users  = getusers($raw);
$lastid = getlastid($raw);
while (!banned($raw)) { // while not banned, run the while
    $raw   = getraw($user, $lastid); // get raw data from chat 
    $users = getusers($raw); // parse the raw data in order to get an array of users
    $a     = getlastid($raw); // get the id of the last message 
    //posted on the chat in order to use it on the next getraw()
    if (!empty($a)) {
        $lastid = $a;
    }
    parse($raw); // parse raw and exec comands sent by users
    sleep(2); // do not waste the bandwidth
}
die("loop ended");
