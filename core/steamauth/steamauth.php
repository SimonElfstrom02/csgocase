<?php
//error_reporting(E_ALL | E_STRICT) ;
//ini_set('display_errors', 'On');
ob_start();
session_start();
require ('core/steamauth/openid.php');
include 'config.php';

$myConnect = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']); 
mysql_select_db($config['db']['base'],$myConnect);


function logoutbutton() {
    echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"Logout\" type=\"submit\" /></form>"; //logout button
}

function steamlogin()
{
try {
    require("core/steamauth/settings.php");
    $openid = new LightOpenID($steamauth['domainname']);
    
    $button['small'] = "small";
    $button['large_no'] = "large_noborder";
    $button['large'] = "large_border";
    //$button = $button[$steamauth['buttonstyle']];
    
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $loginpage = $_GET['loginpage'];
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
    //echo "<form action=\"?login\" method=\"post\"> <button type=\"submit\">Авторизоваться через Steam</button></form>";
}

     elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) { 
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
              
                $_SESSION['steamid'] = $matches[1]; 
                $_SESSION['auth'] = true; 
                $_SESSION['lang'] = 'ru';
                
                //require("core/steamauth/userInfo.php");

                include("core/steamauth/settings.php");
					// Create a stream
			$opts = array(
				'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
							"Cookie: foo=bar\r\n"
				)
			);

			$context = stream_context_create($opts);

                    $urljson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid'], false, $context);
                    $data = json_decode($urljson, true);
					
                    $_SESSION['name'] = $data['response']['players'][0]['personaname'];
                    $_SESSION['avatar'] = $data['response']['players'][0]['avatarmedium'];

                //include_once("set.php");
                $query = mysql_query("SELECT * FROM users WHERE steam='".$_SESSION['steamid']."'");
                if (mysql_num_rows($query) == 0) {
                    mysql_query("SET NAMES 'utf8'");
					mysql_query("SET CHARACTER SET 'utf8'");
                    mysql_query("INSERT INTO users (steam, name, avatar) VALUES ('".$_SESSION['steamid']."',  \"".$_SESSION['name']."\", '".$_SESSION['avatar']."')") or die("MySQL ERROR: ".mysql_error());
                }
                header('Location: http://site.ru');
               
        } else {
                echo "User is not logged in.\n";
        }

    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}

?>
