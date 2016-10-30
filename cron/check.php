<?php
require '/var/www/config.php';
include '/var/www/admin/class/inventory.class.php';
require '/var/www/core/db/pdo.php';
require '/var/www/core/db/db.php';
include '/var/www/case/cases.php';
$pdo = new DATABASE("mysql:host={$config['db']['host']};dbname={$config['db']['base']}", $config['db']['user'], $config['db']['pass']);

file_get_contents('http://site.ru/cron/cron.php');
file_get_contents('http://site.ru/cron/invent.php');

check();

function check() {
  global $arr;
  global $pdo;

  foreach($arr as $name => $value) {
    $s = 0;
    $count = count($arr[$name]);
    for($i = 0; $i < $count; $i++) {
      $name_f = $arr[$name][$i][0] . ' | ' . $arr[$name][$i][4];

      $row = $pdo->__fetch("SELECT COUNT(name) as count FROM `bot` WHERE `wait`=0 AND (`name` = \"{$name_f}\" OR `name` = \"StatTrak™ {$name_f}\")");

      if($row['count'] > 0) {
        $s++;
      }
    }

    if($s > 0) {
      $pdo->query("UPDATE `cases` SET `status`='1' WHERE `name` = '{$name}'");
    } else {
      $pdo->query("UPDATE `cases` SET `status`='0' WHERE `name` = '{$name}'");
    }
  }
}
