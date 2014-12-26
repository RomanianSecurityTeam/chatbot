<?php
include("functions.php");
include("chat.inc.php");
include("custom.php");
include("config.php");

login($account['user'], $account['pass']);

$raw = getraw($account['user']);

if (banned($raw)) {
    die("banned");
}

$users = getusers($raw);
$lastid = getlastid($raw);
while (!banned($raw)) {
    $raw = getraw($account['user'], $lastid);
    $users = getusers($raw);
    $a = getlastid($raw);
    if (!empty($a)) {
        $lastid = $a;
    }
    parse($raw);
    sleep(2);
}
die("loop ended");
?>
