<?php
function gb($s, $e, $h)
{
    @$h = explode($s, $h);
    @$h = explode($e, $h[1]);
    return @$h[0];
}

function parse($raw)
{
    $posts = gb("<messages>", "</messages>", $raw); // get messages from the server
    $posts = explode("</message>", $posts); // split messages by the ending xml tag
    foreach ($posts as $post) {
        $txt = parse_child($post); // parse message and get retuned data
        message($txt); // send returned data
    }
    return true;
}

function parse_child($post)
{
    global $pubfnc, $privfnc, $users, $banned, $chatevents, $priv;
    $priv    = false; // set the $priv global variable to false to send global messages
    $message = gb("<text><![CDATA[", "]]", $post); // get command name and args
    $user    = gb("<username><![CDATA[", "]]", $post); // get the username of the person who executed the command
    $userid  = gb("userID=\"", "\"", $post); // get the userid of the person who executed the command
    if (empty($message)) {
        return false;
    }
    echo $user . ":  " . $message . "\n"; // stdout
    if (in_array($user, $banned)) { // check if the user is banned
        return false;
    }
    $cli = explode(" ", $message, 2); // split the message the user sent as in command name and args
    
    if (isset($pubfnc[$cli[0]])) { // if a function exists and is public
        return @call_user_func($pubfnc[$cli[0]], $cli[1], $user); 	// execute and retun the returned data 
																	//to the function who called this function
    }
    
    if (isset($privfnc[$cli[0]]) && admin($user)) {//if a function exista and is private, and the user has acces to private functions
        return @call_user_func($privfnc[$cli[0]], $cli[1], $user);// execute and retun the data 
    }
    
    if (isset($chatevents[$cli[0]])) {  // if a chatevent is defined 
        return @call_user_func($chatevents[$cli[0]], $cli[1], $user); // execute it and return the data
    }
}

function admin($user)
{
    global $admin;
    return in_array($user, $admin); // check if the user has admin privs
}

function message($cli)
{
    global $user, $priv;
    if (!empty($cli)) { 
        if (strlen($cli) > 255) { //if the sting is longer than 255 chars
            $cli = sprunge(urlencode($cli)); // use a pastebin sevice 
        }
        if ($priv) { // if priv is not false
            $cli = "/msg $priv " . $cli; // send the response on pm of the user who is set on $priv
        }
        postraw($user, $cli); // send the data
    }
}

function generateRandomString($length)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function ban($cli, $user)
{
    global $users, $banned,$priv;
    $priv = $user; // reply on priv
    if (in_array($cli, $users)) { // check if the user is online
        if (!in_array($cli, $banned)) { // check if the user is already banned
            $banned[] = $cli; // ban the user
            return "$cli got banned"; // return message
        }
    }
    return "User is not online or is in baned users list"; // the returned message in case the user is already banned o offline
}

function unban($cli, $user)
{
    global $banned,$priv;
    $priv = $user; // reply on priv
    if (in_array($cli, $banned)) { // check if user is banned
        $banned = array_merge(array_diff($banned, array($cli))); // remove the user from the banned users array
        return "user $cli is unbanned"; // returned message in case anything is fine
    }
    return "user is not banned"; // returned message in case the user is not banned
    
}

function sh($sh)
{
    return ("Result : \n" . shell_exec($sh . " 2>&1"));
    
}

function list_banned($cli, $user)
{
    global $banned,$priv;
    $priv = $user; // reply on priv
    foreach ($banned as $ban) 
        $txt .= $ban . "\n";
    
    return "banned users are: $txt";
}



function pm($cli, $user)
{
    global $priv, $userspm;
    $priv = $user; // reply on priv
    
    if (!empty($userspm[$user]) && empty($cli)) { // if the user does have some offline messages and he want to see them
        foreach ($userspm[$user] as $pm)
            message($pm[0] . ": " . $pm[1]); // send all the messages to the user
        unset($userspm[$user]);
        return false;
    }
    $tmp = explode(" ", $cli, 2); // if the user has some args on the called function
    if (count($tmp) == 2) { // check if he has the correct number of ags
        $userspm[$tmp[0]][] = array($user,$tmp[1]); //  store message in array
        return "Message sent and waiting to be read!";
    }
    
}

function Clogin($cli, $user) // this function is a chat event, and is called everytime someone logs in
{
    global $userspm;
    $priv = $user; // reply on priv
    if (!empty($userspm[$cli])) { // is the user has some messages
        return "you have a new message, to see it, type #pm "; // tell him
    }
}

function Cprivmsg($cli, $user) // this function is a chat event and it executes in case the chatbot has receive a pivate message
{
    global $pubfnc, $privfnc, $priv;
    $priv = $user;
    $cli  = explode(" ", $cli, 2);
    
    if (isset($pubfnc[$cli[0]])) {
        return @call_user_func($pubfnc[$cli[0]], $cli[1], $user);
    }
    
    if (isset($privfnc[$cli[0]]) && admin($user)) {
        return @call_user_func($privfnc[$cli[0]], $cli[1], $user);
    }
    
    $priv = false;
    
}

function sprunge($cli) // post the $cli 's  content on a pastebin service
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://sprunge.us");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "sprunge=" . $cli);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    return curl_exec($ch); // return the url 
}

function killsw() // kill switch
{
    
    exit();
}
