<?php
setcookie("order_id", "", time()-3600); //Убиваем куки
setcookie("order_amount", "", time()-3600); //Убиваем куки
setcookie("user", "", time()-3600); //Убиваем куки
Header ("Location: http://site.ru/payment/payment.php");
?>