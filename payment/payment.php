//VentorHack 14.04.16 Thank VENTORHACK
<?php
//error_reporting(E_ALL | E_STRICT) ;
//ini_set('display_errors', 'On');
include "../config.php";
//
$dbcnx = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']);  
mysql_select_db($config['db']['base'],$dbcnx);
///////////
$merchant_id = 111111; // Логин фрикассы
$secret_word = 'asdasdsa'; // Секретное слово 2
if(empty($_REQUEST['MERCHANT_ORDER_ID'])){
	$merch = $_COOKIE['order_id'];
}else {
	$merch = $_REQUEST['MERCHANT_ORDER_ID'];
}
$order_id = $merch; // ордер
$user = explode('_', $order_id);
$s = md5($merchant_id.$secret_word);
///////////////////////////////////////
$xml = simplexml_load_file("http://www.free-kassa.ru/api.php?merchant_id=".$merchant_id."&s=".$s."&action=check_order_status&order_id=".$order_id."");
$status = $xml->status;
$amount = $xml->amount;
$int = $xml->intid;
/////////////////////////////////////
//echo $order_id;
if($status == 'completed'){
$query = mysql_query("SELECT * FROM log_pay WHERE intid = '$int'");
if (mysql_num_rows($query) == 0) { // проверяем, был ли использован код  
$query = mysql_query("INSERT INTO log_pay (user, log, intid) VALUES ('$user[0]', 'Popolnenie na $amount rub', '$int')") or die("MySQL ERROR: ".mysql_error());;  // Добавляем в базу данные платежа
$query = mysql_query("UPDATE users SET `money` = `money` + '$amount' WHERE id  = '".$user[0]."'") or die("MySQL ERROR: ".mysql_error());;  // Пополняем счёт
setcookie("order_id", "", time()-3600);
Header ("Location: http://site.ru/?yes"); // Редирект после успешной оплаты
//echo "success";
} else { 
Header ("Location: http://site.ru/?no"); // Редирект при пополненом балансе
	//echo "yzhe popolnen";
}
}else{
	Header ("Location: http://site.ru/?no"); // Редирект при ошибке
	//echo "error";
} 
?>