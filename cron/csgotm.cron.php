<?php
/*
*	Чек доступных обменов на csgo.tm и отправка запроса на обмен
*	BlackOnix
*/
include '/var/www/config.php';
$db = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']);
mysql_select_db($config['db']['base'],$db);
	
function curl_send($url){
	$curl = curl_init();
	curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(array(/*здесь массив параметров запроса*/))
	));
	$response = curl_exec($curl);
	curl_close($curl);
	
	return json_decode($response, TRUE);
}

	// Цена и хеш
	$data = curl_send('https://market.csgo.com/api/Trades/?key=key_api');
	$count_content = count($data);
	echo 'В ожидании: '.$count_content.' предмета<br>';
	for ($i=0; $i<$count_content; $i++) {
		$result = $data[$i]['ui_status'];
		$classid = $data[$i]['i_classid'];
		$instanceid = $data[$i]['i_instanceid'];

		if($result == 3){
			echo 'Ожидаем подтверждение от продавца<br>';	
		}
		if($result == 4){
			$bid = $data[$i]['ui_bid'];
			$res = curl_send('https://market.csgo.com/api/ItemRequest/out/'.$bid.'/?key=key_api');
			if($res['success']){
				$msg = 'Запрос на выдачу отправлен. Ник бота - '.$res['nick'].'. Проверочный код - '.$res['secret'].'<br>';
				echo $msg;
			}
			break;
		}
	}
//mysql_query("UPDATE `log_autobot` SET `log` = '".$msg."' WHERE `ids` = '".$classid.'_'.$instanceid."'");
//Узнали цену и хеш
?>