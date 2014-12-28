<?php
function gb($s, $e, $h)
{
    @$h = explode($s, $h);
    @$h = explode($e, $h[1])[0];
    return $h;
}

function parse($raw)
{
    $posts = gb("<messages>", "</messages>", $raw);
    $posts = explode("</message>", $posts);
    foreach ($posts as $post) {
        $txt = parse_child($post);
        message($txt);
    }
    return true;
}

function parse_child($post)
{
    global $pubfnc, $privfnc, $users, $banned,$chatevents,$priv;
		$priv = false;
    $message = gb("<text><![CDATA[", "]]", $post);
    $user = gb("<username><![CDATA[", "]]", $post);
    $userid = gb("userID=\"", "\"", $post);
    if (empty($message)) {
        return false;
    }
    echo $user . ":  " . $message . "\n";
    if (in_array($user, $banned)) {
        return false;
    }
    $cli = explode(" ", $message, 2);

    if (isset($pubfnc[$cli[0]])) {
        return @call_user_func($pubfnc[$cli[0]], $cli[1], $user);
    }

    if (isset($privfnc[$cli[0]]) && admin($user)) {
        return @call_user_func($privfnc[$cli[0]], $cli[1], $user);
    }
    
    if (isset($chatevents[$cli[0]])) {
        return @call_user_func($chatevents[$cli[0]], $cli[1], $user);
    }
}

function admin($user)
{
    global $admin;
    return in_array($user, $admin);
}

function message($cli)
{
    global $user,$priv;
    if (!empty($cli)) {
        if (strlen($cli) > 255) {
            $cli = sprunge(urlencode($cli));
        }
        if($priv){$cli = "/msg $priv ".$cli;}
        postraw($user, $cli);
    }
}


function short_url($url, $key, $uid, $domain = 'adf.ly', $advert_type = 'int')
{
    // base api url
    $api = 'http://api.adf.ly/api.php?';

    // api queries
    $query = array(
        'key' => $key,
        'uid' => $uid,
        'advert_type' => $advert_type,
        'domain' => $domain,
        'url' => $url
    );

    // full api url with query string
    $api = $api . http_build_query($query);
    // get data
    if ($data = file_get_contents($api))
        return $data;
}

function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function ban($cli, $user)
{
    global $users, $banned;
    if (in_array($cli, $users)) {
        if (!in_array($cli, $banned)) {
            $banned[] = $cli;
            return "/msg $user $cli got banned";
        }
    }
    return "/msg $user User is not online or is in baned users list";
}

function unban($cli, $user)
{
    global $banned;
    if (in_array($cli, $banned)) {
        $banned = array_merge(array_diff($banned, array($cli)));
        return "/msg $user user $cli is unbanned";
    }
    return "/msg $user user is not banned";

}

function list_banned($cli, $user)
{
    global $banned;
    foreach ($banned as $ban)
        $txt .= $ban . "\n";

    return "/msg $user banned users are: $txt";
}



function pm($cli, $user)
{
	global $priv, $userspm;
	$priv = $user;
	
    if (!empty($userspm[$user]) && empty($cli)) {
        foreach ($userspm[$user] as $pm)
            message($pm[0] . ": " . $pm[1]);
        unset($userspm[$user]);
        return false;
    }
    $tmp = explode(" ", $cli, 2);
    if ($tmp && count($tmp) == 2) {
        $userspm[$tmp[0]][] = array($user, $tmp[1]);
        return "Message sent and waiting to be read!";
    }

}

function Clogin($cli, $user)
{
    global $userspm;
    $priv = $user;
    if (!empty($userspm[$cli])) {
        return "you have a new message, to see it, type _pm ";
    }
}


function get_string_between ($string, $start, $end)
 {
     $string = " ".$string;
     $ini = strpos($string,$start);
     if ($ini == 0) return "";
     $ini += strlen($start);
     $len = strpos($string,$end,$ini) - $ini;
     return substr($string,$ini,$len);
 }



?>
