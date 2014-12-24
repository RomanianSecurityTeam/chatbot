<?php
function gb($s,$e,$h) {
    @$h = explode($s,$h);
    @$h = explode($e,$h[1])[0];
    return $h;
}

function parse($raw) {
    $posts = gb("<messages>","</messages>",$raw);
    $posts = explode("</message>",$posts);
    foreach($posts as $post) {
        $txt = parse_child($post);
        message($txt);
    }
    return true;
}

function parse_child($post) {
    global $pubfnc,$privfnc,$users,$banned;
    $message = gb("<text><![CDATA[","]]",$post);
    $user = gb("<username><![CDATA[","]]",$post);
    $userid = gb("userID=\"","\"",$post);
    if(empty($message)){return false;}
    echo $user.":  ".$message."\n";
    if(in_array($user,$banned)){return false;
    if($cli[0][0] == "/") $cli[0][0] = "C";
    $cli = explode(" ",$message,2);
    if(in_array($cli[0],$pubfnc)){
      return @call_user_func($cli[0],$cli[1],$user);  
    }

    if(in_array($cli[0],$privfnc) && admin($user)){
      return @call_user_func($cli[0],$cli[1],$user);
    }
}

function admin($user) {
    global $admin;
    return in_array($user, $admin);
}

function message($cli) {
    global $user;
    if(!empty($cli)){
      if(strlen($cli)>100){
        $cli = sprunge(urlencode($cli));
        }
    postraw($user,$cli);
  }
}


function ip_details($ip) {
    $json = file_get_contents("http://ipinfo.io/{$ip}");
    $details = json_decode($json);
    return $details;
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

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function _ban( $cli, $user ) {
	global $users, $banned;
		if( in_array( $cli, $users ) ) {
			if( !in_array( $cli, $banned ) ) {
				$banned[] = $cli;
				return "$cli got banned";
				}
			}
		return "User is not online or is in baned users list";
	}
		
function _unban( $cli, $user ) {
	global $banned;
		if(in_array( $cli, $banned ) ) {
			$banned =  array_merge( array_diff( $banned, array( $cli ) ) );
			return "user $cli is unbanned";
			}
		return "user is not banned";
				
		}
function _banned( $cli, $user ) {
		global $banned;
		foreach ( $banned as $ban ) 
			$txt.=$ban."\n";

		return "banned users are: $txt";
		}
?>
