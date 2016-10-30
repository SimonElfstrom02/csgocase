<?php
header('Content-type: text/html; charset=utf-8');
if(isset($_GET['c'])){
$case = $_GET['c'];
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
	$case2 = $_GET['c'];
}
if($case == 'Operation Breakout Case'){
	$case = 'Operation Breakout Weapon Case';
}
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/pdo.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/db.php';
require $_SERVER["DOCUMENT_ROOT"] . '/config.php';
$pdo = new DATABASE(
	"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
	$config['db']['user'],
	$config['db']['pass']
);

$data = $pdo->query("SELECT * FROM `cases` WHERE `name`='".$case."'");
foreach ($data as $row){
	if($row['status'] == 0){
		$btn = '<button class="opencase-bottom-open"><b class="wheel"></b><span style="margin-right:10px;">Кейс недоступен</span></button>';
	}else{
		$btn = '<button class="opencase-bottom-open" id="start">Открыть кейс</button>';
	}
}
		
$data = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$case}'");
$price = $data['price'];
$status = $data['status'];

?>

<script type="text/javascript" src="/template/js/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="/case/cases2.js"></script>
<script type="text/javascript">
$(document).ready ( function(){	
var currentCase = "<?=$case;?>";
var upchancePrice = "<?=$price;?>";
var statusCase = "<?=$status;?>";
$('#start').html('<b class="wheel"></b>ОТКРЫТЬ КЕЙС - '+upchancePrice+' РУБ.')

function getName(name) {
	var arr = name.split('|');
	return (arr.length == 1) ? name : arr[1];
}
Array.prototype.shuffle = function() {
	var o = this;
	for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
}
Array.prototype.mul = function(k) {
	var res = []
	for (var i = 0; i < k; ++i) res = res.concat(this.slice(0))
	return res
}
Math.rand = function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var el = "";

	cases[currentCase].forEach(function(item, index) {
		el += '<div class="opencase-drops-one">'+
	'<div class="opencase-drops-one-image" style="background-image:url(//steamcommunity-a.akamaihd.net/economy/image/'+item[3]+');"></div>'+
	'<div class="item-incase opencase-drops-one-text '+item[2]+'">'+
		'<div>'+getName(item[0])+'</div>'+
		'<div>'+getName(item[1])+'</div>'+
	'</div>'+
'</div>'
	})

				$(".opencase-drops").html(el);	
				
fillCarusel();
function fillCarusel() {
	
		var a1 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'milspec' }).slice(0).mul(5).shuffle()
		var a2 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'restricted' }).slice(0).mul(5).shuffle()
		var a3 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'classified' }).slice(0).mul(4).shuffle()
		var a4 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'covert' }).slice(0).mul(4).shuffle()
		var a5 = cases[currentCase].filter(function(weapon) { return weapon[2] == 'rare' }).slice(0).mul(2).shuffle()
		
		var arr = a1.concat(a2, a3, a4, a5).shuffle().shuffle().shuffle();
		var el1 = ''
		arr.forEach(function(items, index) {
			var i=Math.floor(Math.random()*2);
			if(i == 1){
				window.b = '';
			}else{
				window.b = '';
			}
		
			el1 += '<div class="weaponblock weaponblock2 '+items[2]+'">'+
						'<img src="https://steamcommunity-a.akamaihd.net/economy/image/'+items[3]+'"/>'+
						'<div class="weaponblockinfo"></div>'+
						'<div class="name"><span>'+ b + getName(items[0])+'<br/>'+getName(items[1])+'</span></div>'+
					'</div>'
			
		})
		$('#casesCarusel').css("margin-left", "0px");
		$('#casesCarusel').html(el1);
		
}
$('#start').click(function(){
	this.disabled = true;
	$('#start').html('<b class="wheel"></b><span style="margin-right:30px;">Открываем...</span>');
		$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'openCase',
				'case': currentCase,
				async: 'false',
				'upchancePrice': upchancePrice
			},
			success: function(data) {
				
				if (data.status == 'success') {
					
					$('#bal').html(data.balance + ' <small></small>');
					$('#opcase').text(parseInt($('#opcase').text()) + 1);
					
					var weapon = data.weapon
					var weaponName = b + weapon.firstName + ' | ' + weapon.secondName
					
					var nameus = data.user;
					
					
					//$('#casesCarusel > div:nth-child(30), #casesCarusel .item-incase').removeClass('milspec restricted classified covert rare').addClass(weapon.type)
					
					$('#casesCarusel > div:nth-child(30), #weaponBlock .recweap').removeClass('milspec restricted classified covert rare').addClass(weapon.type)
					$('#casesCarusel > div:nth-child(30) .name span').html(b + weapon.firstName+'<br/>'+weapon.secondName)
					$('#casesCarusel > div:nth-child(30)').find('img').attr('src', 'https://steamcommunity-a.akamaihd.net/economy/image/' + weapon.image)				
					
										
					
					var a = 1431 + 16*122;
					$('#casesCarusel').animate({ marginLeft: -1 * Math.rand(a, a+50) }, {
						duration: 10000,
						easing: 'swing',
						//easing: 'easeInSine',
						start: function() {
							caseScrollAudio.play()
						},
						complete: function() {
							caseCloseAudio.play()

					socketf.emit('lastWin', { 
						'weaponname': data.socket.name,
						'userid': data.socket.userid,
						'type': data.socket.type,
						'img': data.socket.img,
						'caseimg': data.socket.case,
						'user': data.socket.user
					});
					
								

							document.getElementById("start").style.display='none';
							
							var el2 = '<div id="win" class="opencase-opened widther" style="display: block;">'+
										'<div class="opencase-opened-title">Поздравляем! Ваш выигрыш:</div>'+
										'<div class="opencase-opened-drop"><img id="wp" src="https://steamcommunity-a.akamaihd.net/economy/image/'+weapon.image+'" width="128"></div>'+
										'<p align="center" class="'+weapon.type+'">'+weapon.firstName+' | '+weapon.secondName+'</p>'+
										'<div class="opencase-opened-actions widther">'+
											'<div class="opencase-opened-actions-one s__again" style="margin-right: 20px;">'+
												'<div class="opencase-opened-actions-one-image"></div>'+
												'<div class="opencase-opened-actions-one-text buttonwin" onclick="location.reload();">Еще раз</div>'+
											'</div>'+
											'<div class="opencase-opened-actions-one s__sell">'+
												'<div class="opencase-opened-actions-one-image"></div>'+
												'<div class="opencase-opened-actions-one-text buttonwin" onclick="sell('+weapon.id+');">Продать за <strong>'+weapon.pricew+'р</strong></div>'+
											'</div>'+
										'</div>'+
										'<div class="opencase-opened-out">Предмет нужно вывести в профиле в течении часа</div>'+
									'</div>'
							
							
							
							$('#scrollerContainer').html(el2);
							$(el2).fadeIn(1000);
						}
					})
				}
				else {
					if(data.msg == 'notauth')
					{
						$('#start').css('display', 'none');
						$('.error').html('<center><a href="/?login"><div class="opencase-bottom-auth"><b class="key"></b>Авторизуйтесь</div></a></center>');
					}
					if(data.msg == 'errlink')
					{
						$('#start').css('display', 'none');
						$('.error').html('<center><a href="/user/me"><div class="opencase-bottom-link">Укажите ссылку на обмен в <span>профиле</span></div></a></center>');
					}
					if(data.msg == 'err')
					{
						$('#start').css('display', 'none');
						$('.error').html('<center><a href="#"><div class="opencase-bottom-link">Возникла ошибка</div></a></center>');
					}
					if(data.msg == 'errbalance')
					{
						$('#start').css('display', 'none');
						$('.opencase-bottom-nofunds').html('<div class="opencase-bottom-nofunds-title">Недостаточно средств</div>'+
						'<div class="opencase-bottom-nofunds-subtitle">У вас недостаточно средств для открытия кейса!</div>'+
						'<div class="opencase-bottom-nofunds-add">'+
							'<form method="post" action="/payment/send.php">'+
								'<input type="text" name="summ" class="opencase-bottom-nofunds-add-sum" value="'+upchancePrice+'">'+
								'<button type="submit" class="opencase-bottom-nofunds-add-btn">Пополнить</button>'+
							'</form>'+
						'</div>');
					}
				}
				upchancePrice = '';
			},
			error: function() {
				alert('Произошла ошибка! Попробуйте еще раз');
				this.disabled = false;
			}
		})
	});	

});
//
function sell(item_id){
		if (confirm("Вы действительно хотите продать выигранный предмет?"))
  {
	$(".opencase-opened-actions").hide();
  var img = $('#wp').attr('src');

			$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'sellItem',
				'ids': item_id,
				'case': "<?=$case;?>",
				'img': img

			},
			success: function(data) {
				$('#bal').html(data.plus + ' <small></small>');
				location.reload();
			},
			error: function() {
				alert('Произошла ошибка! Обратитесь к администратору');
			}
		})	
  }
       }
	   
window.onload = function() {
		$("#cont").css("transition", "All 1s ease");
		document.getElementById("preloader").style.cssText="display:none";
		document.getElementById("cont").style.cssText="display:block";
	}

</script>
<?php
echo '
<div id="preloader" class="preloader" style="display: block;margin-top:20px;margin-bottom:-350px;"><center><img src="/template/img/preloader.GIF"></center></div>
<div class="opencase nobg" id="cont" style="display:none;">
	<div class="opencase-title">Главная     →     <span>'.$case2.'</span></div>
	<div id="scrollerContainer">
		<div id="caruselLine"></div>
		<div id="caruselOver"></div>
		<div id="aCanvas">
			<div id="casesCarusel" style="margin-left: 0px;">
			</div>
		</div>
	</div>
	<div class="opencase-bottom widther">
		'.$btn.'					
		<div class="error"></div>
		<div class="opencase-bottom-nofunds"></div>
	</div>
	<div class="opencase-drops widther"></div>
</div>
	';
}
?>
