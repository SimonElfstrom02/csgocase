<?php
header('Content-type: text/html; charset=utf-8');
if(isset($_GET['id'])){
$id = $_GET['id'];
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/pdo.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/db.php';
require $_SERVER["DOCUMENT_ROOT"] . '/config.php';
$pdo = new DATABASE(
	"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
	$config['db']['user'],
	$config['db']['pass']
);
		
$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id`='{$id}'");
$name = $data['name'];
$avatar = str_replace("medium", "full", $data['avatar']);;
$steam = $data['steam'];
//$cases = $data['cases'];

//Инвентарь
$inv = $pdo->query("SELECT * FROM `inventory` WHERE `user`='{$id}' ORDER BY `id` DESC LIMIT 20");
if($inv){	
foreach ($inv as $row){
	$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
	$full_name = $row['weapon'].' | '.$row['second'];
	$type = $row['type'];
	if($row['status'] == 'completed') {
				$status = '<div class="active" title="Предмет получен"></div>';
			}
			if($row['status'] == 'progress'){
				 $status = '<div class="out" title="Предмет отправлен"></div>';
			}
			if($row['status'] == 'selled') {
				$status = '<div class="view" title="Предмет продан"></div>';
			}
			if($row['status'] == 'notcompleted') {
				$status = '<div class="out" title="Предмет отправлен"></div>';
			}
	$el .= '<div class="opencase-drops-one">
	<div class="drops-status">
		<div class="coast">'.$row['price'].'P</div>	
		'.$status.'
	</div>
	<div class="opencase-drops-one-image" id="profileimage" style="background-image:url(https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].')">
		<a href="/?case='.$row['case'].'"><img src="'.$cs['img'].'" style="height: 80px;margin-top: 6px;"></a>
	</div>
	<div class="opencase-drops-one-text '.$type.'">
		<div>'.$row['weapon'].'</div>
		<div>'.$row['second'].'</div>
	</div>
</div>';
}
}else{
	$el = 'нету';
}

//!Инвентарь
?>
<script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script>
<?php
echo '
<div class="opencase nobg">
	<div class="wrap">
		<div class="userprofil">
			<div class="lcol">
				<img src="'.$avatar.'" alt="" width="186">
				<br>
				<br>
				<a href="http://steamcommunity.com/profiles/'.$steam.'" class="profsteam" target="_blank">Профиль STEAM</a>
			</div>
			<div class="rcol">
				<p style="text-align: center;font-size: 28px;color: #fff;margin-top: -1%;margin-bottom: 2%;">Предметы &gt; <span id="usernames">'.$name.'</span></p>
				<div class="opencase-drops nmg">
					'.$el.'					
				</div>
			</div>
		</div>
	</div>
</div>
	';
}
?>
