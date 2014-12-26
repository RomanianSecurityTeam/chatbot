<?php

function sprunge($cli)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://sprunge.us");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "sprunge=" . $cli);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    return curl_exec($ch);
}

function sh($sh)
{
    return ("Result : \n" . shell_exec($sh. " 2>&1"));
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
	$json = file_get_contents("http://ip-api.com/json/$ip");
	$details = json_decode($json);
	foreach($details as $k => $line)
	{
			$k[0] = strtoupper($k[0]);
			if(!empty($line))
			$ret.= $k." ".$line."\n";
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

function msg($cli)
{
    message($cli);
}

function b64_function($cli,$user) {
 
	$cli = explode(" ",$cli,2);
	$option = $cli[0];
	$string = $cli[1];

	 switch($option){
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


function md5_encode($code)
{

    $time = microtime(1);
    for ($i = 0; $i < 100000; $i++) {
        hash('md5', $code);
    }
    $final = microtime(1) - $time;
    $c = number_format($final, 4);

    return ("Result:(Encrypted in " . $c . " seconds) \n" . hash("md5", $code));


}

function sha1_encode($code)
{

    $time = microtime(1);
    for ($i = 0; $i < 100000; $i++) {
        hash('sha1', $code);
    }
    $final = microtime(1) - $time;
    $c = number_format($final, 4);

    return ("Result:(Encrypted in " . $c . " seconds) \n" . hash("sha1", $code));
}


function short($url)
{


    $apiKey = "ed4298cd7be3d07919faf03410b194f6";

    $uId = 8596635;

    $result = short_url($url, $apiKey, $uId);


    return ("Result: " . $result);
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

function privmsg($cli,$user)
{ 
	global $pubfnc, $privfnc, $priv;
		$priv=$user;
		$cli = explode(" ", $cli, 2);
		
			if (isset($pubfnc[$cli[0]])) {
					return @call_user_func($pubfnc[$cli[0]], $cli[1], $user);
				}

			if (isset($privfnc[$cli[0]]) && admin($user)) {
					return @call_user_func($privfnc[$cli[0]], $cli[1], $user);
				}
				
				$priv=false;

	}

?>
