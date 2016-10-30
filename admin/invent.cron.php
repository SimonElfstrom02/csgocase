<?php
include '/var/www/config.php';
	$db = mysql_connect('127.0.0.1','root','---------');
	mysql_select_db('-------',$db);
	
		$get_content = file_get_contents("http://steamcommunity.com/id/gaben/inventory/json/730/2");
		$data_image = (array) json_decode($get_content) -> rgInventory;
		$count_content = count($data_image);
		$data_content = (array) json_decode($get_content, TRUE);
		mysql_query('truncate table `bot`', $db);
		for ($i=0; $i<$count_content; $i++) {
			
			$element_name = array_shift($data_content[rgInventory]);
			$name_item = "$element_name[classid]_$element_name[instanceid]";
			$name = $data_content['rgDescriptions'][$name_item]['name'];
			//$name = str_replace("StatTrak™", "", $name);
				mysql_query("SET NAMES 'utf8'");
				mysql_query("SET CHARACTER SET 'utf8'");
				mysql_query("INSERT INTO `bot` (
					`id` ,
					`name`,
					`name2`
				)
				VALUES (
					NULL ,  \"{$name}\", \"{$name}\"
				)",$db);
			
			
		}
		echo 'ok';
?>