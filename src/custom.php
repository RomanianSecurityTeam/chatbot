<?php
/* |=====================================================|
 * |Custom functions                                     |
 * | Q: How to make a custom function?                   |
 * | A: simple                                           |
 * | Declare the function in this file, and return what  |
 * |        you want to display to the user              |
 * |	                                                 |
 * |    function HelloWorld($cli,$user)                  |
 * |    {                                                |
 * |                                                     |
 * |    return "Hello World! by $user";                  |
 * |    }                                                |
 * |                                                     |
 * | More built-in functions to use when you write a     |
 * | custom function:                                    |
 * | - 	gb($start, $end, $string)                        |
 * |        + get string between $start and $end         |
 * |                                                     |
 * | - 	admin($user)                                     |
 * |        + check if a $user is admin                  |
 * |                                                     |
 * | - message($text)                                    |
 * |        + post message on chat                       |
 * |        + you can send a private message by setting  |
 * |                global variable $priv to the username|
 * |                you want to send                     |
 * |                                                     |
 * | - ban($user)                                        |
 * | - unban($user)                                      |
 * |=====================================================|
 * */

function privmsg($cli, $user) // this function is executed when a user wants to get the reply of his command on priv8
{
  return Cprivmsg($cli,$user); // simulate a pivate message
    
}


function whois($domain)
{
    if ((preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain) && preg_match("/^.{1,253}$/", $domain) && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain))) {
        return (shell_exec("whois $domain"));
    } else {
        return ("Mofo, check yo domain and hit the ducking enter");
    }
}

function ip($ip)
{
    $json    = file_get_contents("http://ip-api.com/json/$ip");
    $details = json_decode($json);
    foreach ($details as $k => $line) {
        $k[0] = strtoupper($k[0]);
        if (!empty($line))
            $ret .= $k . " " . $line . "\n";
    }
    
    return $ret;
}


function ping($ip)
{
    
    $result = array();
    
    /* Execute Shell Command To Ping Target */
    if ((preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $ip) && preg_match("/^.{1,253}$/", $ip) && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $ip))) {
        
        $cmd_result = shell_exec("ping -c 1 -w 1 $ip");
    } else {
        return ("Invalid domain/ip. ");
    }
    /* Get Results From Ping */
    $result = explode(",", $cmd_result);
    
    /* Return Server Status */
    if (eregi("0 received", $result[1])) {
        return ("Target : [color=yellow][b]" . $ip . "[/b][/color] | Status : [color=red][b]OFFLINE[/b][/color]");
    } elseif (eregi("1 received", $result[1])) {
        return ("Target : [color=yellow][b]" . $ip . "[/b][/color] | Status : [color=lime][b]ONLINE[/b][/color]");
    } else {
        return ("Target : [color=yellow][b]" . $ip . "[/b][/color] | Status : [color=yellow][b]UNREACHABLE(Does not exist!)[/b][/color]");
    }
}

function host($domain)
{
    if ((preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain) && preg_match("/^.{1,253}$/", $domain) && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain))) {
        return (shell_exec("host $domain"));
    } else {
        return ("Mofo, check yo domain and hit the ducking enter");
    }
}

function help($cli, $user)
{
    global $priv;
    $priv   = $user;
    $cli    = explode(" ", $cli, 1);
    $option = $cli[0];
    
    switch ($option) {
        case "bot":
            $output = file_get_contents("botinfo.txt", true);
            break;
        case "commands":
            $output = file_get_contents("botcommands.txt", true);
            break;
    }
    return " \n$output";
    
}


function weather($oras)
{
    
    $url  = "http://vremeainpulamea.sirb.net/?oras=" . urlencode($oras);
    $html = file_get_contents($url);
    if (preg_match("#Ai stricat pagina#", $html)) {
        $output = "Locatia [b][color=green] " . $oras . "[/color][/b] este inexistenta.";
    } else {
        $locatie     = get_string_between($html, "&raquo;", "</title>");
        $locatie     = str_replace(" ", "", $locatie);
        $temperatura = get_string_between($html, "<h2>", "</h2>");
        $temperatura = str_replace("??!!!", "", $temperatura);
        
        $output = "Locatie : [b]" . $locatie . "[/b]. Temperatura : [b]" . $temperatura . "[/b]";
    }
    return $output;
}



function isup($url, $user)
{
    global $priv;
    $priv = $user;
    if (strrpos($url, "http") === false) {
        $url = "http://" . $url;
    }
    if (@!file_get_contents($url)) {
        return "URL: $url STATUS: offline";
    } else {
        return "URL: $url STATUS: online";
    }
}





function b64_function($cli, $user)
{
    
    $cli    = explode(" ", $cli, 2);
    $option = $cli[0];
    $string = $cli[1];
    
    switch ($option) {
        case "encode":
            $outputs = base64_encode($string);
            break;
        case "decode":
            $outputs = base64_decode($string);
            break;
        default:
            $outputs = "How to use :\n - #b64 encode <string> -> Encode the string given in Base64\n  - #b64 decode <string> -> Decode the string given from Base64";
            break;
    }
    return $outputs;
}



function encode($cli, $user)
{
    
    $cli    = explode(" ", $cli, 2);
    $option = $cli[0];
    $string = $cli[1];
    
    switch ($option) {
        case "md5":
            $time = microtime(1);
            for ($i = 0; $i < 100000; $i++) {
                hash("sha1", $string);
            }
            $final = microtime(1) - $time;
            $c     = number_format($final, 4);
            
            $output = "Result:(Encrypted in " . $c . " seconds) \n" . hash("md5", $string);
            break;
        case "sha1":
            $time = microtime(1);
            for ($i = 0; $i < 100000; $i++) {
                hash("sha1", $string);
            }
            $final = microtime(1) - $time;
            $c     = number_format($final, 4);
            
            $output = "Result:(Encrypted in " . $c . " seconds) \n" . hash("sha1", $string);
            break;
        case "sha256":
            $time = microtime(1);
            for ($i = 0; $i < 100000; $i++) {
                hash("sha256", $string);
            }
            $final = microtime(1) - $time;
            $c     = number_format($final, 4);
            
            $output = "Result:(Encrypted in " . $c . " seconds) \n" . hash("sha256", $string);
            break;
        case "sha384":
            $time = microtime(1);
            for ($i = 0; $i < 100000; $i++) {
                hash("sha384", $string);
            }
            $final = microtime(1) - $time;
            $c     = number_format($final, 4);
            
            $output = "Result:(Encrypted in " . $c . " seconds) \n" . hash("sha384", $string);
            break;
        case "sha512":
            $time = microtime(1);
            for ($i = 0; $i < 100000; $i++) {
                hash("sha512", $string);
            }
            $final = microtime(1) - $time;
            $c     = number_format($final, 4);
            
            $output = "Result:(Encrypted in " . $c . " seconds) \n" . hash("sha512", $string);
            break;
            
    }
    return $output;
}

function short($cli,$user)
{
	$array = array("longUrl"=>$cli);
	$json = json_encode($array);
	$url = "https://www.googleapis.com/urlshortener/v1/url";
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    return "Results: ". json_decode(curl_exec($ch))->id;
}

function passwd_generate($var, $user)
{
    global $priv;
    $priv = $user;
    if ($var == "1") {
        
        $output = generateRandomString(10);
        
        return ("Result : " . $output);
    } elseif ($var == "2") {
        $output = generateRandomString(15);
        return ("Result : " . $output);
    } elseif ($var == "3") {
        $output = generateRandomString(20);
        return ("Result : " . $output);
    } elseif (!$var) {
        return ("Error! Usage : passwd_generate <1/2/3> ");
    }
}
