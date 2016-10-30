<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/config.php';
include $_SERVER["DOCUMENT_ROOT"] . '/admin/class/inventory.class.php';
include $_SERVER["DOCUMENT_ROOT"] . '/admin/class/stats.class.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/pdo.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/db.php';


$pdo = new DATABASE(
	"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
	$config['db']['user'],
	$config['db']['pass']
);

//Админы
$stmt = $pdo->prepare('SELECT * FROM users WHERE admin = :admin');
$stmt->execute(array('admin' => '1'));
//Админы

//Последнии выигрыши
$lastw = $pdo->prepare('SELECT * 
FROM  `last` 
ORDER BY  `id` DESC 
LIMIT 0 , 30');
$lastw->execute();

//Последнии выигрыши

//кейсы
$cases = $pdo->prepare('SELECT * 
FROM  `cases`');
$cases->execute();
//кейсы

//кейсы2
$cases2 = $pdo->prepare('SELECT * 
FROM  `cases`');
$cases2->execute();
//кейсы2

//Наиб. часто
$cases3 = $pdo->prepare('SELECT * 
FROM  `cases` 
ORDER BY `count` DESC 
LIMIT 0 , 1');
$cases3->execute();

//Наиб. часто

$access = false;

$status = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$_SESSION['steamid']}'");
if($status['admin'] == '1') $access = true; 

if($access){
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/bootstrap.min.js"></script>

<?php

if(isset($_GET['autobuy'])){
	include $_SERVER["DOCUMENT_ROOT"] . '/admin/autobuy.php';
	exit;
}else{
?>
<script>
$(document).ready ( function(){	
$('#deleted').click(function(){
	var steam = $(this).attr('steam');
	$.ajax({
			url: '/ajax/',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'delAdmin',
				'steam': steam

			},
			success: function(data) {
				location.reload();
			},
			error: function() {
				alert('Произошла ошибка! Обратитесь к администратору');
			}
		})
});
});
</script>
<br><br><br>
<div class="container">
<div class="jumbotron">
<div class="bs-example bs-example-tabs">
    <ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#stats" data-toggle="tab">Статистика</a></li>
      <li class=""><a href="#inventory" data-toggle="tab">Инвентарь</a></li>
      <li class="dropdown">
          <a href="#" id="cat" class="dropdown-toggle" data-toggle="dropdown">Категории<b class="caret"></b></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="cat">
            <li><a href="#milspec" tabindex="-1" data-toggle="tab">Армейское оружие</a></li>
            <li><a href="#restricted" tabindex="-1" data-toggle="tab">Запрещенное оружие</a></li>
			<li><a href="#classified" tabindex="-1" data-toggle="tab">Засекреченное оружие</a></li>
			<li><a href="#covert" tabindex="-1" data-toggle="tab">Тайное оружие</a></li>
			<li><a href="#rare" tabindex="-1" data-toggle="tab">Ножевой кейс</a></li>
          </ul>
        </li>
		
		<li class="dropdown">
          <a href="#" id="cases" class="dropdown-toggle" data-toggle="dropdown">Кейсы<b class="caret"></b></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="cases">
			<li><a href="#revolver" tabindex="-1" data-toggle="tab">Revolver Case</a></li>
            <li><a href="#chroma2" tabindex="-1" data-toggle="tab">Chroma 2 Case</a></li>
            <li><a href="#falchion" tabindex="-1" data-toggle="tab">Falchion Case</a></li>
			<li><a href="#shadow" tabindex="-1" data-toggle="tab">Shadow Case</a></li>
			<li><a href="#winter" tabindex="-1" data-toggle="tab">Winter Offensive Weapon Case</a></li>
			<li><a href="#vanguard" tabindex="-1" data-toggle="tab">Operation Vanguard Weapon Case</a></li>
			<li><a href="#phoenix" tabindex="-1" data-toggle="tab">Operation Phoenix Weapon Case</a></li>
			<li><a href="#huntsman" tabindex="-1" data-toggle="tab">Huntsman Weapon Case</a></li>
			<li><a href="#breakout" tabindex="-1" data-toggle="tab">Operation Breakout Weapon Case</a></li>
			<li><a href="#chroma" tabindex="-1" data-toggle="tab">Chroma Case</a></li>
			<li><a href="#bravo" tabindex="-1" data-toggle="tab">Operation Bravo Case</a></li>
			<li><a href="#wc1" tabindex="-1" data-toggle="tab">CS:GO Weapon Case</a></li>
			<li><a href="#wc2" tabindex="-1" data-toggle="tab">CS:GO Weapon Case 2</a></li>
			<li><a href="#wc3" tabindex="-1" data-toggle="tab">CS:GO Weapon Case 3</a></li>
			<li><a href="#es13" tabindex="-1" data-toggle="tab">eSports 2013 Case</a></li>
			<li><a href="#es13w" tabindex="-1" data-toggle="tab">eSports 2013 Winter Case</a></li>
			<li><a href="#es14s" tabindex="-1" data-toggle="tab">eSports 2014 Summer Case</a></li>
          </ul>
        </li>
		
		<li class="dropdown">
          <a href="#" id="rand" class="dropdown-toggle" data-toggle="dropdown">Случайные<b class="caret"></b></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="rand">
            <li><a href="#usp" tabindex="-1" data-toggle="tab">Случайный USP-S</a></li>
            <li><a href="#glock" tabindex="-1" data-toggle="tab">Случайный Glock-18</a></li>
			<li><a href="#desert" tabindex="-1" data-toggle="tab">Случайный Desert Eagle</a></li>
			<li><a href="#m4a4" tabindex="-1" data-toggle="tab">Случайный M4A4</a></li>
			<li><a href="#m4a1" tabindex="-1" data-toggle="tab">Случайный M4A1-S</a></li>
			<li><a href="#ak47" tabindex="-1" data-toggle="tab">Случайный AK-47</a></li>
			<li><a href="#awp" tabindex="-1" data-toggle="tab">Случайный AWP</a></li>
          </ul>
        </li>
		
		<li class=""><a href="#admins" data-toggle="tab">Список администраторов</a></li>
		<li class=""><a href="#refill" data-toggle="tab">Пополнить баланс</a></li>
		<li class=""><a href="#lastwins" data-toggle="tab">Последнии выигрыши</a></li>
		<li class=""><a href="#case_price" data-toggle="tab">Стоимость кейсов</a></li>
		<li class=""><a href="#addcase" data-toggle="tab">Добавка кейсов</a></li>
		<li class=""><a href="?autobuy">Автозакупка</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="stats">
       <div class="row placeholders">
			<center><h2 style="color:#F55450;">Статистика</h2></center>
			<hr>
            <?php //echo stats(); ?>
			<?php 
			foreach($cases3 as $rsf ){
				echo '<h3>Наиболее часто открывают кейс: '. $rsf['count'].' ('.$rsf['disp_name'].')</h3>';
			}?>
			<hr>
			<table class="table table-hover">
			
				<tr>
					<th>Описание</th><th>Результат</th>
				</tr>
				<tr><td>Статистика открытий кейсов:</td><td>--------</td></tr>
				<?php
			foreach($cases2 as $rst ){
				$itog = $rst['count']*$rst['price'];
				echo '<tr><td>'.$rst['disp_name'].'</td><td>'.$rst['count'].' раз (Итого: '.$itog.' рублей)</td></tr>';
			}
			?>
			<tr><td>-------</td><td>--------</td></tr>
			</table>
			
          </div>
      </div>
	  <div class="tab-pane fade" id="inventory">
        <div class="row" style="width: 100%; margin: 0 auto;">
		<center><h2 style="color:#F55450;">Инвентарь бота</h2></center>
		<?php echo inventory();?>
		</div>
      </div>
	  <!--Категории-->
		<div class="tab-pane fade" id="milspec">
		<center><h2>Армейское оружие</h2></center>
			<table class="table table-hover">
			
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo milspec();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="restricted">
		<center><h2 style="color:#F55450;">Запрещенное оружие</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo restricted();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="classified">
		<center><h2>Засекреченное оружие</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo classified();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="covert">
		<center><h2 style="color:#F55450;">Тайное оружие</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo covert();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="rare">
		<center><h2 style="color:#F55450;">Ножевой кейс</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo rare();?>
			</table>
		</div>
		
		<!--Кейсы-->
		
		<div class="tab-pane fade" id="revolver">
		<center><h2 style="color:#F55450;">Revolver Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo revolver();?>
			</table>
		</div>

		<div class="tab-pane fade" id="chroma2">
		<center><h2 style="color:#F55450;">Chroma 2 Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo chroma2();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="falchion">
		<center><h2 style="color:#F55450;">Falchion Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo falchion();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="shadow">
		<center><h2 style="color:#F55450;">Shadow Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo shadow();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="winter">
		<center><h2 style="color:#F55450;">Winter Offensive Weapon Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo winter();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="vanguard">
		<center><h2 style="color:#F55450;">Operation Vanguard Weapon Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo vanguard();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="phoenix">
		<center><h2 style="color:#F55450;">Operation Phoenix Weapon Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo phoenix();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="huntsman">
		<center><h2 style="color:#F55450;">Huntsman Weapon Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo huntsman();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="breakout">
		<center><h2 style="color:#F55450;">Operation Breakout Weapon Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo breakout();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="chroma">
		<center><h2 style="color:#F55450;">Chroma Casee</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo chroma();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="bravo">
		<center><h2 style="color:#F55450;">Operation Bravo Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo bravo();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="wc1">
		<center><h2 style="color:#F55450;">CS:GO Weapon Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo wc1();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="wc2">
		<center><h2 style="color:#F55450;">CS:GO Weapon Case 2</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo wc2();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="wc3">
		<center><h2 style="color:#F55450;">CS:GO Weapon Case 3</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo wc3();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="es13">
		<center><h2 style="color:#F55450;">eSports 2013 Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo es13();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="es13w">
		<center><h2 style="color:#F55450;">eSports 2013 Winter Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo es13w();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="es14s">
		<center><h2 style="color:#F55450;">eSports 2014 Summer Case</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo es14s();?>
			</table>
		</div>
		<!--Кейсы-->
		
		<!--Случайные-->
		
		<div class="tab-pane fade" id="usp">
		<center><h2 style="color:#F55450;">Случайный USP-S</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo usp();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="glock">
		<center><h2 style="color:#F55450;">Случайный Glock-18</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo glock();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="desert">
		<center><h2 style="color:#F55450;">Случайный Desert Eagle</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo desert();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="m4a4">
		<center><h2 style="color:#F55450;">Случайный M4A4</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo m4a4();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="m4a1">
		<center><h2 style="color:#F55450;">Случайный M4A1-S</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo m4a1();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="ak47">
		<center><h2 style="color:#F55450;">Случайный AK-47</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo ak47();?>
			</table>
		</div>
		
		<div class="tab-pane fade" id="awp">
		<center><h2 style="color:#F55450;">Случайный AWP</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Название</th><th>В наличии</th>
				</tr>
				<?php echo awp();?>
			</table>
		</div>
		
		<!--Список администраторов-->
		
		<div class="tab-pane fade" id="admins">
		<center><h2 style="color:#F55450;">Админлист</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Никнейм</th><th>SteamID</th><th>Действие</th>
				</tr>
				<?php 
				foreach($stmt as $row){
					echo '<tr><td>'.$row['name'].'</td><td>'.$row['steam'].'</td><td>
					<form method="POST" action="/ajax/">
					<input type="hidden" name="action" value="delAdmin">
					<input type="hidden" name="steam" value="'.$row['steam'].'">
					<input type="submit" class="btn btn-warning" value="X">
					</form>
					</td></tr>';
				}
				?>
			</table>
			<center><h3 style="color:#F55450;">Добавление администраторов</h2></center>
			<form class="form-inline" method="POST" action="/ajax/">
				<input type="hidden" name="action" value="addadminsteam">
				<div class="form-group">
					<input type="text" class="form-control" name="steam" placeholder="76561198036284814">
				</div>
				
				<input type="submit" class="btn btn-default" value="Добавить по SteamID">
			</form>
			<form class="form-inline" method="POST" action="/ajax/">
				<input type="hidden" name="action" value="addadminid">
				<div class="form-group">
					<input type="text" class="form-control" name="id" placeholder="25">
				</div>
				<input type="submit" class="btn btn-default" value="Добавить по ID">
			</form>
		</div>
		
		<!-- Пополнение баланса -->
		
		<div class="tab-pane fade" id="refill">
			<center><h3 style="color:#F55450;">Пополнение баланса</h2></center>
			<form class="form-inline" method="POST" action="/ajax/">
				<input type="hidden" name="action" value="addMoneySteamid">
				<div class="form-group">
					<input type="text" class="form-control" name="amount" placeholder="Сумма">
					<input type="text" class="form-control" name="steam" placeholder="76561198036284814">
				</div>
				<input type="submit" class="btn btn-default" value="Пополнить по SteamID">
			</form>
			<form class="form-inline" method="POST" action="/ajax/">
				<input type="hidden" name="action" value="addMoneyId">
				<div class="form-group">
					<input type="text" class="form-control" name="amount" placeholder="Сумма">
					<input type="text" class="form-control" name="id" placeholder="25">
				</div>
				<input type="submit" class="btn btn-default" value="Пополнить по ID">
			</form>
		</div>
		
		<!-- Последнии выигрыши -->
		
		<div class="tab-pane fade" id="lastwins">
		<center><h2 style="color:#F55450;">Последние 30 выигрышей</h2></center>
			<table class="table table-hover">
				<tr>
					<th>Имя</th><th>Кейс</th><th>Оружие</th>
				</tr>
				<?php 
				foreach($lastw as $rowl){
					$case = $rowl['casename'];
					if($case == 'milspec'){
						$case2 = 'Армейское оружие';
					}else
					if($case == 'restricted'){
						$case2 = 'Запрещенное оружие';
					}else
					if($case == 'classified'){
						$case2 = 'Засекреченное оружие';
					}else
					if($case == 'covert'){
						$case2 = 'Тайное оружие';
					}else
					if($case == 'rare'){
						$case2 = 'Ножевой кейс';
					}else{
						$case2 = $rowl['casename'];
					}
					echo '<tr><td>'.$rowl['username'].'</td><td>'.$case2.'</td><td>'.$rowl['weapon'].'</td></tr>';
				}
				?>
			</table>
		</div>
		
		<!-- Цены на кейсы -->
		
		<div class="tab-pane fade" id="case_price">
		<center><h2 style="color:#F55450;">Изменение цен на кейсы</h2></center>
			<form class="form-inline" method="POST" action="/ajax/">
				<input type="hidden" name="action" value="editCase">
				<div class="form-group">
						<select class="form-control" name="case">
							<option value="0" disabled="disabled" selected="">Выберите Кейс</option>
							<?php
							foreach($cases as $rc ){
								echo '<option value='.$rc['id'].'>'.$rc['disp_name'].' - '.$rc['price'].' рублей</option>';
							}
							?>
						</select>
						<input type="text" class="form-control" name="price" placeholder="Цена">
						<input type="submit" class="btn btn-default" value="Изменить">
					</div>
			</form>
		</div>

		<!--Добавление кейса-->

		<div class="tab-pane fade" id="addcase">
		<center><h2 style="color:#F55450;">Добавление кейса</h2></center>
			<form class="form-inline" method="POST" action="/ajax/">
				<input type="hidden" name="action" value="addCase">
				<div class="form-group">
					<input type="text" class="form-control" name="namec" placeholder="Name">
					<input type="text" class="form-control" name="dispname" placeholder="Disp Name">
					<input type="text" class="form-control" name="imgc" placeholder="img">
					<input type="text" class="form-control" name="pricec" placeholder="price">
					<input type="text" class="form-control" name="typec" placeholder="type">
					<input type="text" class="form-control" name="statusc" placeholder="status">
					<input type="text" class="form-control" name="varc" placeholder="var">
					<input type="text" class="form-control" name="countc" placeholder="count">
					<input type="submit" class="btn btn-default" value="Добавить">
				</div>
			</form>
		</div>
		
    </div>
  </div>
</div>
</div>
<?php
}
}else{
	echo "You don't have access. <a href='/?login'>Login</a>";
}

?>