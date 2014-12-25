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


    if ($ip) {

        $details = ip_details($ip);
        // Prelucram datele din $details

        $delimiter = " / ";

        $coords_raw = $details->loc;

        $coords = explode(",", $coords_raw);

        $show_ip = "IP : [color=green][b]" . $ip . "[/b][/color]";


        $show_city = "City : [color=yellow][b]" . $details->city . "[/b][/color]";

        $show_country = "Country : [color=red][b]" . $details->country . "[/b][/color]";

        $show_region = "Region : [color=teal][b]" . $details->region . "[/b][/color]";

        $show_hostname = "Hostname : [color=fuchsia][b]" . $details->hostname . "[/b][/color]";

        $show_postal = "Postal : [color=aqua][b]" . $details->postal . "[/b][/color]";

        $show_lat = "Latitude : [color=orange][b]" . $coords[0] . "[/b][/color]";

        $show_long = "Longitude : [color=orange][b]" . $coords[1] . "[/b][/color]";

        $show_coords = $show_lat . $delimiter . $show_long;


        if (!$coords[0] && !$coords[1]) {
            $show_coords = "[color=orange][b]No coords found![/b][/color]";
        }
        if (!$details->postal) {
            $show_postal = "[color=aqua][b]No postal code found![/b][/color]";
        }
        if (!$details->city) {
            $show_city = "[color=yellow][b]No city found![/b][/color]";
        }
        if (!$details->country) {
            $show_country = "[color=red][b]No country found![/b][/color]";
        }
        if (!$details->region) {
            $show_region = "[color=teal][b]No region found![/b][/color]";
        }
        if (!$details->hostname) {
            $show_hostname = "[color=fuchsia][b]No hostname found![/b][/color]";
        }

        //Le afisam cu return

        return ($show_ip . $delimiter . $show_city . $delimiter . $show_country . $delimiter . $show_region . $delimiter . $show_postal . $delimiter . $show_hostname . $delimiter . $show_coords);
    }


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

function b64_encode($code)
{

    $time = microtime(1);
    for ($i = 0; $i < 100000; $i++) {
        base64_encode($code);
    }
    $final = microtime(1) - $time;
    $c = number_format($final, 4);

    return ("Result:(Encrypted in " . $c . " seconds) \n" . base64_encode($code));
}

function b64_decode($code)
{

    $time = microtime(1);
    for ($i = 0; $i < 100000; $i++) {
        base64_decode($code);
    }
    $final = microtime(1) - $time;
    $c = number_format($final, 4);


    return ("Result:(Decrypted in " . $c . " seconds) \n" . base64_decode($code));
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
