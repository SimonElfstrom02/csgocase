<?php
//VentorHack 14.04.16 Thank VENTORHACK
session_start();
error_reporting(E_ALL & ~E_NOTICE);
define("BASE_URL", __DIR__);
require BASE_URL . '/core/db/pdo.php';
require BASE_URL . '/core/db/db.php';
require BASE_URL . '/core/system.php';
require BASE_URL . '/config.php';
//include(BASE_URL . '/core/steamauth/steamauth.php');
//require('core/steamauth/steamauth.php');
//steamlogin();                                   // ESKRIPT.RU                  / ESKRIPT.RU             / ESKRIPT.RU           / ESKRIPT.RU

if(isset($_GET['logout'])){
	include('core/steamauth/logout.php');
	exit;
}

if(isset($_GET['login'])){
	include('core/steamauth/steamauth.php');
	steamlogin();
	exit;
}

if($_GET['page'] == 'profile'){
	if(!$_SESSION['auth']) Header ("Location: http://site.ru");
}

if (empty($_GET['ajax'])) {
	
	//if(isset($_SESSION["steamid"])) {
		//require BASE_URL . '/core/steamauth/userInfo.php';
	//}
	//if ($_SESSION['auth']) {
				
		
		require BASE_URL . '/core/structure.php';
		require BASE_URL . '/core/route.php';
		$page = (empty($_GET['page']) || $_GET['page'] == "/") ? "index" : $_GET['page'];
		if(isset($_GET['case'])){
			Page::Generate('0', '0', $_GET['case'],'0');
		}elseif(isset($_GET['id'])){
			Page::Generate('0', '0', '', $_GET['id']);
		}else{
		Page::Generate(Route::start($page, $_GET['mode'], '', '0'));
		}
	//} else {
		//echo set("auth");
		//include('auth.php');
		//exit;
	//}
} else {
	switch($_GET['ajax']) {
		case "auth" : 
			require BASE_URL . "/auth.php"; $auth = new Auth();
			echo $auth->AuthForm();
		break;
	}
}
?>
