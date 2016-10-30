<?php
/*
*	���������� ��������� � �� ��������� API Steam
*	BlackOnix
*/

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$db = mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['pass']);
mysql_select_db($config['db']['base'], $db);

$get_content = file_get_contents("http://steamcommunity.com/id/gaben/inventory/json/730/2");
$data_image = (array)json_decode($get_content)->rgInventory;
$count_content = count($data_image);
$data_content = (array)json_decode($get_content, TRUE);
mysql_query('truncate table `bot`', $db);
for($i = 0; $i < $count_content; $i++) {
  $element_name = array_shift($data_content[rgInventory]);
  $name_item = "$element_name[classid]_$element_name[instanceid]";
  $name = $data_content['rgDescriptions'][$name_item]['name'];

  mysql_query("SET NAMES 'utf8'");
  mysql_query("SET CHARACTER SET 'utf8'");

  $result = mysql_query("SELECT * FROM `cron` WHERE `item_id`='{$element_name['id']}'");
  var_dump(mysql_num_rows($result));

  if(mysql_num_rows($result) == 0) {
    mysql_query("INSERT INTO `bot` (`name`, `item_id`, `wait`) VALUES (\"{$name}\", {$element_name['id']}, 0)", $db);
  } else {
    mysql_query("INSERT INTO `bot` (`name`, `item_id`, `wait`) VALUES (\"{$name}\", {$element_name['id']}, 1)", $db);
  }
}

echo 'ok';
