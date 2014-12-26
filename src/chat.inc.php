<?php
function login($u, $p)
{
    $post = array('s' => '', 'cookieuser' => 1, 'do' => 'login', 'url' => 'https://rstforums.com/chat/?channelName=RST', 'vb_login_username' => $u, 'vb_login_password' => $p);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://rstforums.com/forum/login.php?do=login");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "tmp/$u");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "tmp/$u");
    curl_setopt($ch, CURLOPT_REFERER, "https://rstforums.com/chat/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    return curl_exec($ch);
}


function getraw($u, $id = 1337)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://rstforums.com/chat/?ajax=true&lastID=$id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "tmp/$u");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "tmp/$u");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    return curl_exec($ch);
}

function postraw($u, $msg)
{
    $post = array("text" => $msg);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://rstforums.com/chat/?ajax=true");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "tmp/$u");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "tmp/$u");
    curl_setopt($ch, CURLOPT_REFERER, "https://rstforums.com/chat/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    return curl_exec($ch);
}

function banned($raw)
{
    return false;
}

function getusers($raw)
{
    $realusers = array();
    $rawusers = gb("<users>", "</users>", $raw);
    $users = explode("<user ", $rawusers);
    unset($users[0]);
    foreach ($users as $line) {
        $userid = gb("userID=\"", "\"", $line);
        $username = gb("<![CDATA[", "]]", $line);
        $realusers[$userid] = $username;
    }
    $users = $realusers;
    return $users;
}

function getlastid($raw)
{
    $lastid = gb("<messages>", "</messages>", $raw);
    $lastid = explode("</message>", $lastid);
    @$lastid = $lastid[count($lastid) - 2];
    $lastid = gb("id=\"", "\"", $lastid);
    return $lastid;
}

?>
