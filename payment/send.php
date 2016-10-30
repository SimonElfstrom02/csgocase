//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
//VentorHack 14.04.16 Thank VENTORHACK
<?php
session_start();
if(isset($_POST)){
?>

<?php
if($_POST['wm']) {
	if(empty($_POST['summ'])) {
		$am = 29;
	}else {
		$am = $_POST['summ'];
	}
	//////////////////////////////////////////
	$mrh_login = "dasdasd"; // логин robokassa
	$mrh_pass1 = "asdasd"; // пароль 1 robokassa
	////////////////////////
	$shp_item = $_SESSION['id']; // Пользователь
	$out_summ = $am; // сумма
	$inv_id = 0; // номер заказа
	$inv_desc = "Пополнение"; // описание заказа
	$culture = "ru"; // язык
	$encoding = "utf-8"; // кодировка
	$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:shp_Item=$shp_item"); // подпись
	////////////////////////
	echo "<form id=\"send\" action=\"https://auth.robokassa.ru/Merchant/Index.aspx\" method=\"POST\">
 			<input type=\"hidden\" name=\"MrchLogin\" value=".$mrh_login.">
 			<input type=\"hidden\" name=\"OutSum\" value=".$out_summ.">
 			<input type=\"hidden\" name=\"InvId\" value=".$inv_id.">
 			<input type=\"hidden\" name=\"Desc\" value=".$inv_desc.">
 			<input type=\"hidden\" name=\"SignatureValue\" value=".$crc.">
 			<input type=\"hidden\" name=\"shp_Item\" value=".$shp_item.">
 			<input type=\"hidden\" name=\"Culture\" value=".$culture.">
 			<input type=\"hidden\" name=\"Encoding\" value=".$encoding.">
 			<input type=\"submit\"  value=\"Pay\">
		</form>
		<script type=\"text/javascript\">
   			 document.getElementById('send').submit();
		</script>";
}else{
//
$merchant_id = 126543; /// login freekassa

if(empty($_POST['summ'])) {
	$order_amount = 29;
}else {
	$order_amount = $_POST['summ'];
}

$u = $_SESSION['id'];

$order_id = $u.'_'.$order_amount.'_'.time();

$secret_word = 'asdasd'; /// word freekassa

$sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);
setcookie("order_id", $order_id, time()+3600);
//setcookie("order_amount", $order_amount, time()+3600);
//setcookie("user", $u, time()+3600);
header('Location: http://www.free-kassa.ru/merchant/cash.php?m='.$merchant_id.'&oa='.$order_amount.'&o='.$order_id.'&s='.$sign.'&lang=ru&us_login='.$u.'');
exit();
}
?>

<?php
}else{
	echo 'error';
}
?>