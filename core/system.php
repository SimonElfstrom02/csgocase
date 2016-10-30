<?php
function set($file, $replace = NULL)
{
	$path = "template/{$file}.tpl";
	if (@file_get_contents($path)) {
		$out = file_get_contents($path);
	} else {
		return msg("Файла {$path} не существует!");
	}
	if (!empty($replace)) {
		foreach($replace as $key => $element)
		{
			$out = str_replace($key, $element, $out);
		}
	}
	return $out;
}

function msg($text, $type = "danger")
{
	$out = $text;
	return $out;
}

function myhash_check($real, $base)
{
	
	$tmp = explode('$', $base);
	return (hash('sha256', hash('sha256', $real) . $tmp[2]) == $tmp[3]) ? true : false;
}

function myhash($pass)
{
	$salt = substr(hash('sha256', uniqid(rand())), 0, 16);
	return ("$"."IS$".$salt."$".hash('sha256',hash('sha256', $pass).$salt));
}

function browser_check($u_agent)
{
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i', $u_agent)) {
        return "IE";
    } elseif(preg_match('/Firefox/i', $u_agent)) {
        return "Firefox";
    } elseif(preg_match('/Chrome/i', $u_agent)) {
        return "Google";
	} elseif(preg_match('/Safari/i', $u_agent)) {
        return "Safari";
    } elseif(preg_match('/Opera/i', $u_agent)) {
        return "Opera";
    } elseif(preg_match('/Netscape/i', $u_agent)) {
        return "Netscape";
    } 
}

function NoneMoney($price)
{
	return $price - $_SESSION['rub'];
}

function ValidationSteamID($steamid)
{
	$exp = explode(":", $steamid); // [0] => (string) STEAM_X, [1] => (int) 1 or 0, [2] => (int) strlen = 8
	if ($exp[1] > 1 || $exp[1] < 0) return false;
	if (strlen((string) $exp[2]) < 6 || strlen((string) $exp[2]) > 12) return false;
	return true;
}
?>