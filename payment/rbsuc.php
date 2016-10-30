<?php
//error_reporting(E_ALL | E_STRICT) ;
//ini_set('display_errors', 'On');
include "../config.php";
$dbcnx = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']);  
mysql_select_db($config['db']['base'],$dbcnx);
/////////////////////////// 
$mrh_login = "asdasd"; // login robo
$mrh_pass1 = "iasdasd"; // pass1 robo
$mrh_pass2 = "iasdasd"; // pass2 robo
/////////////////////////
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["shp_Item"];
$crc = $_REQUEST["SignatureValue"];
/////////////////////////
$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:shp_Item=$shp_item"));
$crkek = md5("$mrh_login:$inv_id:$mrh_pass2");
/////////////////////////
if ($my_crc != $crc)
{
  Header ("Location: http://site.ru/?no");
  exit();
}
////////////////////////
$xml = simplexml_load_file("https://auth.robokassa.ru/Merchant/WebService/Service.asmx/OpState?MerchantLogin=".$mrh_login."&InvoiceID=".$inv_id."&Signature=".$crkek."");
$status = $xml->State->Code;
$am = round($out_summ);
///////////////////////
if($status == '100'){
$query = mysql_query("SELECT * FROM log_pay WHERE intid = '$inv_id'");
if (mysql_num_rows($query) == 0) { // проверяем, был ли использован код  
$query = mysql_query("INSERT INTO log_pay (user, log, intid) VALUES ('$shp_item', 'Popolnenie na $am rub', '$inv_id')") or die("MySQL ERROR: ".mysql_error());;  // Добавляем в базу данные платежа
$query = mysql_query("UPDATE users SET `money` = `money` + '$am' WHERE id  = '".$shp_item."'") or die("MySQL ERROR: ".mysql_error());;  // Пополняем счёт
Header ("Location: http://site.ru/?yes"); // Редирект после успешной оплаты
exit();
//echo "success";
//echo $status;
} else { 
Header ("Location: http://site.ru/?yes"); // Редирект при пополненом балансе
exit();
	//echo "yzhe popolnen";
}
}else{
	Header ("Location: http://site.ru/?no"); // Редирект при ошибке
	exit();
	//echo "error";
} 
?>