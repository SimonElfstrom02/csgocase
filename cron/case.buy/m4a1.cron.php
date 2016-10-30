<?php
function check_price($name){
	$cn = 0;
	//Покупаем оружие
	$myCurl2 = curl_init();
	curl_setopt_array($myCurl2, array(
		CURLOPT_URL => "https://market.csgo.com/itemdb/current_730.json",
		CURLOPT_RETURNTRANSFER => true
	));
	$bd = curl_exec($myCurl2);
	curl_close($myCurl2);

	$bd2 = json_decode($bd, TRUE);

	if (($handle = fopen("https://market.csgo.com/itemdb/".$bd2['db'], "r")) !== FALSE) {
		$arr = array();
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$array2 = explode(';', $data[$c]);
				//echo $array2[0].' | ';
				//echo $array2[9];
				$pos = strpos($array2[9], $name);
				if ($pos === false) {
				
				}else{
					$cn++;
					$arr[$cn]['price'] = $array2[2];
					$arr[$cn]['id'] = $array2[0].'_'.$array2[1];
					$arr[$cn]['name'] = $array2[9];
				}
			}
		}
		fclose($handle);
		sort($arr);
		foreach($arr as $v){
			$res[0] = $v['price'];
			$res[1] = $v['id'];
			$res[2] = $v['name'];
			// Цена и хеш
			$myCurl = curl_init();
			curl_setopt_array($myCurl, array(
				CURLOPT_URL => 'https://market.csgo.com/api/ItemInfo/'.$res[1].'/en/?key=key_api',
				CURLOPT_RETURNTRANSFER => true
			));
			$response = curl_exec($myCurl);
			curl_close($myCurl);
			$datas = json_decode($response, TRUE);

			//Узнали цену и хеш
			if(isset($datas['error'])){

			}else{
				$res[3] = $datas['offers'][0]['price'];
				$res[4] = $datas['hash'];
				break;
			}
		}
		print_r($res);
		buy($res[1], $res[2], $res[3], $res[4]);
	}
}

function buy($id, $name, $price, $hash){
	
	include $_SERVER["DOCUMENT_ROOT"] . '/config.php';
	$db = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']);
	mysql_select_db($config['db']['base'],$db);

	//Покупаем оружие
	$myCurl2 = curl_init();
	curl_setopt_array($myCurl2, array(
		CURLOPT_URL => "https://market.csgo.com/api/Buy/".$id."/".$price."/".$hash."/?key=key_api",
		CURLOPT_RETURNTRANSFER => true
	));
	$buy = curl_exec($myCurl2);
	curl_close($myCurl2);

	$buy2 = json_decode($buy, TRUE);
	$result = $buy2['result'];
	if($buy2['result'] == 'Ошибка в запросе'){
		$result = 'Нету в наличии...';
	}
	if(isset($name)){
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER SET 'utf8'");
		mysql_query('INSERT INTO `log_autobot`(`id`, `log`, `name`, `ids`, `price`, `date`) VALUES (NULL, \''.$result.'\', \''.$name.'\', \''.$id.'\', \''.$price.'\', \''.date("d.m.y H:i:s").'\')');
	}
	return $buy2['result'];
}

function m4a1(){
	include $_SERVER["DOCUMENT_ROOT"] . '/case/cases.php'; $c = 0;
	$count = count($arr['M4A1-S Case']);
	for ($i=0; $i<$count; $i++) {
		include $_SERVER["DOCUMENT_ROOT"] . '/config.php';
		$db = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']);
		mysql_select_db($config['db']['base'],$db);
		$name_f = $arr['M4A1-S Case'][$i][0].' | '.$arr['M4A1-S Case'][$i][4];
		$sql = "SELECT COUNT(name) FROM `bot` WHERE `name` = \"{$name_f}\" OR `name` = \"StatTrak™ {$name_f}\""; mysql_query("SET NAMES 'utf8'"); mysql_query("SET CHARACTER SET 'utf8'");
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$total = $row[0];
			if($total == 0){
				check_price($arr['M4A1-S Case'][$i][0].' | '.$arr['M4A1-S Case'][$i][1]);
				$c++;
			}
	}
	if($c>0){
		mysql_query("UPDATE `cases` SET `status`='0' WHERE `name` = 'M4A1-S Case'");
	}
	return true;
}

echo m4a1();
?>