<script type="text/javascript" src="/template/js/jquery.js"></script>
<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
<?php
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/pdo.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pdo = new DATABASE("mysql:host={$config['db']['host']};dbname={$config['db']['base']}", $config['db']['user'], $config['db']['pass']);

$query = $pdo->query("SELECT * FROM `cron` WHERE `status` = 'wait'");

while($row = $query->fetch()) {
  if($row['time'] <= date('Y-m-d H:i:s')) {
    include $_SERVER["DOCUMENT_ROOT"] . '/case/cases.php';

    $inventory = $pdo->__fetch("SELECT * FROM `inventory` WHERE `id`='{$row['idw']}' and `status`='progress'");

    $img = str_replace("-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpo", "", $inventory['img']);
    $img = str_replace("fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz", "", $img);

    foreach($arr[$inventory['case']] as $item) {
      if($item[3] == $img) {
        $price = $item[5];
        $name = $item[0] . ' | ' . $item[4];
        break;
      }
    }

    $pdo->query("UPDATE `users` SET `money` = `money` + '{$price}' WHERE `id`='{$inventory['user']}'");

    $pdo->query("DELETE FROM `cron` WHERE `id`='{$row['id']}'");

    $pdo->query("UPDATE `inventory` SET `status` = 'selled' WHERE `id` = '{$inventory['id']}'");
  }
  echo "ok";
}
