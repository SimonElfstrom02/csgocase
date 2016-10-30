<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/pdo.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/db.php';
require $_SERVER["DOCUMENT_ROOT"] . '/config.php';

$pdo = new DATABASE(
    "mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
    $config['db']['user'],
    $config['db']['pass']
);

/*
	Изменение количества одного оружия в кейсе
*/
if (trim($_POST["action"]) == "editCount") {
    $case = $_POST['case'];
    $count = $_POST['count'];
    $pdo->query("UPDATE `autobot_case` SET `count` = '{$count}' WHERE `name`='{$case}'");
    header('Location: http://site.ru/admin/?autobuy');
}
/*
	Изменение лимита
*/
if (trim($_POST["action"]) == "editLimit") {
    $weapon = $_POST['weapon'];
    $limit = $_POST['limit'];
    $pdo->query("UPDATE `autobot_weapon` SET `limit` = '{$limit}' WHERE `name`='{$weapon}'");
    header('Location: http://site.ru/admin/?autobuy');
}
/*
	Добавление администратора по SteamID
*/
if (trim($_POST["action"]) == "addadminsteam") {
    $steam = $_POST['steam'];
    $pdo->query("UPDATE `users` SET `admin` = '1' WHERE `steam`='{$steam}'");
    header('Location: http://site.ru/admin/');
}
/*
	Добавление администратора по ID
*/
if (trim($_POST["action"]) == "addadminid") {
    $id = $_POST['id'];
    $pdo->query("UPDATE `users` SET `admin` = '1' WHERE `id`='{$id}'");
    header('Location: http://site.ru/admin/');
}
/*
	Удаление администратора
*/
if (trim($_POST["action"]) == "delAdmin") {
    $steam = $_POST['steam'];
    $pdo->query("UPDATE `users` SET `admin` = '0' WHERE `steam`='{$steam}'");
    header('Location: http://site.ru/admin/');
}
/*
	Пополнение баланса по SteamID
*/
if (trim($_POST["action"]) == "addMoneySteamid") {
    $amount = $_POST['amount'];
    $steam = $_POST['steam'];
    $pdo->query("UPDATE `users` SET `money` = `money`+'{$amount}' WHERE `steam`='{$steam}'");
    header('Location: http://site.ru/admin/');
}
/*
	Пополнение баланса по ID
*/
if (trim($_POST["action"]) == "addMoneyId") {
    $amount = $_POST['amount'];
    $id = $_POST['id'];
    $pdo->query("UPDATE `users` SET `money` = `money`+'{$amount}' WHERE `id`='{$id}'");
    header('Location: http://site.ru/admin/');
}
/*
	Сохранение ссылки
*/
if (trim($_POST["action"]) == "saveLink") {
    $link = $_POST['url'];
    $pdo->query("UPDATE `users` SET `link` = '$link' WHERE `steam`='{$_SESSION['steamid']}'");
    header('Location: http://site.ru/user/me');
}
/*
	Изменение стоимость кейсов
*/
if (trim($_POST["action"]) == "editCase") {
    $case = $_POST['case'];
    $price = $_POST['price'];
    $pdo->query("UPDATE `cases` SET `price` = '{$price}' WHERE `id`='{$case}'");
    header('Location: http://site.ru/admin/');
}
/*
	Добавление кейса	
*/
if (trim($_POST["action"]) == "addCase") {
    $namec = $_POST['namec'];
    $dispn = $_POST['dispname'];
    $imgc = $_POST['imgc'];
    $pricec = $_POST['pricec'];
    $typec = $_POST['typec'];
    $statusc = $_POST['statusc'];
    $varc = $_POST['varc'];
    $countc = $_POST['countc'];
    $pdo->query("INSERT INTO `cases` (`name`, `disp_name`, `img`, `price`, `type`, `status`, `var`, `count`) VALUES ('{$namec}', '{$dispn}', '{$imgc}', '{$pricec}', '{$typec}', '{$statusc}', '{$varc}', '{$countc}')");
    header('Location: http://site.ru/admin/');
}

/*
	Продажа оружия
*/
if (trim($_POST["action"]) == "sellItem") {

    include $_SERVER["DOCUMENT_ROOT"] . '/case/cases.php';
    $case = $_POST['case'];
    $ids = $_POST['ids'];
    $img = $_POST['img'];

    $img = str_replace("https://steamcommunity-a.akamaihd.net/economy/image/", "", $img);

    foreach ($arr[$case] as $row) {
        if ($row[3] == $img) {
            $price = $row[5];
            $name = $row[0] . ' | ' . $row[4];
            break;
        }
    }
    
    $data = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$_SESSION['steamid']}'");




    $inventory = $pdo->__fetch("SELECT * FROM `inventory` WHERE `id`='{$ids}'");




    if (is_null($inventory)) {
    	echo '{"status":"error","msg":"itemerror"}';
    	  exit;
}


    if ($inventory['user'] != $_SESSION['id']) {
    	echo '{"status":"error","msg":"itemerror"}';
    	  exit;
}

  

    if ($inventory['status'] == 'selled' or $inventory['status'] == 'completed') {
    	echo '{"status":"error","msg":"itemerror"}';
    	  exit;
}
  

    $balance = $data['money'];
    $plus = $balance + $price;

    $res = '{
	"price": ' . $price . ',
	"plus": ' . $plus . '
	}';

    $pdo->query("UPDATE `bot` SET `wait` = 0 WHERE `item_id`='{$inventory['item_id']}'");

    $pdo->query("DELETE FROM `cron` WHERE `item_id`='{$inventory['item_id']}'");

    $pdo->query("UPDATE `users` SET `money` = '{$plus}' WHERE `steam`='{$_SESSION['steamid']}'");
    $pdo->query("UPDATE `inventory` SET `status` = 'selled' WHERE `id`='{$ids}' and `user`='{$_SESSION['id']}' and `status`='progress'");

    file_get_contents('http://site.ru/cron/check.php');

    exit($res);
}

/*
	Открытие кейса
*/
if (trim($_POST["action"]) == "openCase") {// Открытие кейса
    if (empty($_SESSION['auth'])) {
        echo '{"status":"error","msg":"notauth"}';
        exit;
    }
    $uprice = $_POST["upchancePrice"];
    $data = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$_SESSION['steamid']}'");
    $balance = $data['money'];
//////////check
    $checkminus = $balance - $price;
    if ($checkminus < 0) {
        echo '{"status":"error","msg":"errbalance"}';
        exit;
    }
///////checkk
    $link = $data['link'];
    $ids = $data['id'];


  $casesf = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$_POST["case"]}'");
    
  if ($uprice < $casesf['price']) {
        echo '{"status":"error","msg":"errbalance"}';
        exit;
    }



    if ($balance < $uprice) {
        echo '{"status":"error","msg":"errbalance"}';
        exit;
    }
    $checkminus = $balance - $uprice;
    if ($checkminus < 0) {
        echo '{"status":"error","msg":"errbalance"}';
        exit;
    }
    if ($balance < 0) {
        echo '{"status":"error","msg":"errbalance"}';
        exit;
    }
    if ($uprice == 0) {
        echo '{"status":"error","msg":"errbalance"}';
        exit;
    }

    if ($link == '') {
        echo '{"status":"error","msg":"errlink"}';
        exit;
    }

    include $_SERVER["DOCUMENT_ROOT"] . '/case/cases.php';
    $case = $_POST["case"];//$case = $case[steamRandom($uprice,$case,$arr)];


    if ($uprice < 0) {
        echo '{"status":"errorb","msg":"Не успешно"}';
        exit;
    }

    $i = 0;

    $rese = $pdo->query("SELECT * FROM `bot` WHERE `wait`=0");
    while ($row = $rese->fetch()) {
        foreach ($arr[$case] as $key => $rows) {
            $name_ff = $rows[0] . ' | ' . $rows[4];
            if ($row['name'] == $name_ff) {

                $rand_keys[$i] = $key;
                $i++;
                //break;
                if ($i > 5) break;
            }
        }
    }
    if (empty($rand_keys)) {
        echo '{"status":"error","msg":"err"}';
        exit;
    }
    shuffle($rand_keys);
    shuffle($rand_keys);
    shuffle($rand_keys);
    shuffle($rand_keys);
    shuffle($rand_keys);
    $cnt = count($rand_keys) - 1;
    $num = rand(0, $cnt);
    $rand_keysz = $rand_keys[$num];
//$cn = count($rand_keys);
//shuffle($rand_keys);
//for ($t=0; $t<1; $t++) {
    //$rand_keysz = array_rand($rand_keys, 1);
//}


//$rand_keys = array_rand($arr[$case], 1);
    $cs = $arr[$case][$rand_keysz];
    $caseID = "0";

    $type = $cs[2];
    $firstName = $cs[0];
    $secondName = $cs[1];

    $fullName = $firstName . " | " . $secondName;

    $image = $cs[3];


    $caseimg = $casesf['img'];

    foreach ($arr[$case] as $row) {
        if ($row[3] == $image) {
            $en = $row[4];
            $pricew = $row[5];
            break;
        }
    }


    $stattrack = false;
//$rando = rand(1,10);
//if($rando == 1){
//	$stattrack = true; //Cтартрек
//	$stattracklog = "StatTrak™ ";
//}

//if($stattrack == true){
//	$fullname = $stattracklog . ' ' . $firstName." | ".$secondName;
//	$firstName = 'StatTrak™ ' . $firstName;
//}


    $imgweapontomysql = $image;


    $balance2 = $balance - $uprice;

    $imgsock = 'https://steamcommunity-a.akamaihd.net/economy/image/' . $imgweapontomysql;

//$pdo->query("INSERT INTO `last` (`username`, `userid`, `casename`, `weapon`, `type`, `img`, `imgcase`) VALUES ('{$_SESSION['name']}', '{$_SESSION['id']}', '{$_POST["case"]}', '{$fullName}', '{$type}', '{$image}', '{$caseimg}')");

//$pdo->query("INSERT INTO `inventory` (`weapon`, `second`, `seconden`, `type`, `img`, `price`, `case`, `user`, `status`) VALUES ('{$firstName}', '{$secondName}', '{$en}', '{$type}', '{$imgweapontomysql}', '{$pricew}', '{$case}', '{$_SESSION['id']}', 'progress')");

    $engfullname = $firstName . ' | ' . $en;



    $en_mysql = str_replace("'", "\\'", $en);
    $engfullname_mysql = str_replace("'", "\\'", $engfullname);

    $bot_item = $pdo->__fetch("SELECT * FROM `bot` WHERE `name`=\"{$engfullname}\" AND `wait`=0 LIMIT 1");

    $pdo->query("UPDATE `users` SET `money` = `money` - '$uprice' WHERE `steam`='{$_SESSION['steamid']}'");

    $pdo->query("UPDATE `stats` SET `cases` = `cases` + 1");

    $pdo->query("UPDATE `users` SET `cases` = `cases` + 1 WHERE `steam`='{$_SESSION['steamid']}'");

    $pdo->query("UPDATE `users` SET `profit` = `profit` + '$pricew' WHERE `steam`='{$_SESSION['steamid']}'");

    $pdo->query("UPDATE `cases` SET `count` = `count` + 1 WHERE `name` = '{$case}'");

    $balance2 = $balance - $uprice;

    $pdo->query("INSERT INTO `inventory` (`weapon`, `second`, `seconden`, `type`, `img`, `price`, `case`, `user`, `status`, `item_id`) VALUES (\"{$firstName}\", \"{$secondName}\", \"{$en_mysql}\", '{$type}', \"{$imgweapontomysql}\", '{$pricew}', '{$case}', '{$_SESSION['id']}', 'progress', {$bot_item['item_id']})");

    $inventory_item_id = $pdo->lastInsertId();

    $pdo->query("INSERT INTO `last` (`username`, `userid`, `casename`, `weapon`, `type`, `img`, `imgcase`) VALUES (\"{$_SESSION['name']}\", '{$_SESSION['id']}', '{$_POST["case"]}', \"{$fullName}\", '{$type}', '{$image}', '{$caseimg}')");

    $time = time();

    $pdo->query("INSERT INTO `cron`(`userid`, `weapon`, `price`, `time`, `idw`, `item_id`) VALUES ('{$_SESSION['id']}',\"{$engfullname_mysql}\",'{$pricew}','" . date('Y-m-d H:i:s', $time + 3600) . "', {$inventory_item_id}, {$bot_item['item_id']})");

    $pdo->query("UPDATE `bot` SET `wait`='1' WHERE `item_id`={$bot_item['item_id']}");

    @file_get_contents('http://site.ru/cron/check.php');

    $echoCase = '{"status":"success",
"weapon":{ 
	"id":"' . $inventory_item_id . '",
	"caseimg":"' . $caseimg . '",
	"fullName":"' . $fullName . '",
	"firstName":"' . $firstName . '",
	"secondName":"' . $secondName . '", 
	"type":"' . $type . '",
	"image":"' . $image . '", 	
	"price": ' . $uprice . ',
	"pricew": ' . $pricew . ',
	"stattrack":"' . $stattrack . '"
},
"userid":"' . $_SESSION['id'] . '",
"user":"' . $_SESSION['name'] . '",
"balance":' . $balance2 . ',
"debug":"SELECT * FROM `bot` WHERE `name`=' . $engfullname . ' AND `wait`=0 LIMIT 1",
"socket":{
	"name":"' . $engfullname . '",
	"userid":"' . $_SESSION['id'] . '",
	"type":"' . $type . '",
	"img":"' . $imgsock . '",
	"case":"' . $caseimg . '",
	"user":"' . $_SESSION['name'] . '"
}
}';


    /*if($case == 'rare'){
        file_get_contents('http://site.ru/cron/checkcase.cron.php?buy_knife=1&knife='.$fullname);
    }*/


    exit($echoCase);

}

/* 
	Отправка оружия
*/
if (trim($_POST["action"]) == "send") {
    $return = $_POST;
    $cookie_name = 'exabyte_url';
    if (!isset($_COOKIE['send_timeout'])) {
        $return = $_POST;
        $checkwp = $pdo->__fetch("SELECT * FROM `inventory` WHERE `id`='{$return['id']}'");
        if ($checkwp['user'] == $_SESSION['id']) {
            if ($checkwp['status'] == 'selled') exit();
            $pdo->query("UPDATE `inventory` SET `status` = 'notcompleted' WHERE `id`='{$return['id']}' and `user`='{$_SESSION['id']}'");
            $tradelink = $pdo->__fetch("SELECT * FROM `users` WHERE `steam` = '{$_SESSION['steamid']}'");

            //$token = substr(strstr($tradelink['link'], 'token='),6);

            $row3 = explode("https://steamcommunity.com/tradeoffer/new/?", $tradelink['link'], 2);
            $row2 = explode("partner=", $row3[1]);
            $row = explode("&token=", $row2[1]);

            $return['status'] = 'success';
            $return['wp'] = $return["weapon"];
            $return['steam'] = $_SESSION['steamid'];
            $return['details'] = $row;
            $return['id'] = $return["id"];
            $price = $return['price'];
            $return['userid'] = $_SESSION['id'];
            $lol = 'lol';
            $return['pre'] = md5($return['wp'].$lol);


            $pdo->query("UPDATE `inventory` SET `status` = 'completed' WHERE `id`='{$return['id']}' and `user`='{$_SESSION['id']}' and `status`='progress'");

            $idiq = $pdo->query("select `id` from `inventory` WHERE `id`='{$return['id']}' and `user`='{$_SESSION['id']}' and `status` = 'completed'");
            $assocArrayi = $idiq->fetch();
            $idi = $assocArrayi[0];

            $pdo->query("DELETE FROM `cron` WHERE `idw`='{$idi}'");
            setcookie('send_timeout', $return["weapon"], time() + (60), '/');
        } else {
            $return['status'] = 'error';
        }
    } else {
        $return['status'] = 'cookie';
    }
    echo json_encode($return);
}
