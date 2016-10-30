<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
<script>
$(function () {	
$(".tosell").click(function() {
$('.tosell').css('display','none');
	if (confirm("Вы действительно хотите продать выигранный предмет?"))
  {
  var img = $(this).attr('imgw');
  var cases = $(this).attr('case');
   var ids = $(this).attr('ids');
   var inst = $('[data-remodal-id=sellok]').remodal();
					inst.open();
			$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'sellItem',
				'case': cases,
				'ids': ids,
				'img': img
			},
			success: function(data) {
				$('#bal').html(data.plus + ' <small>p</small>');
				location.reload();
			},
			error: function() {
				alert('Произошла ошибка! Обратитесь к администратору');
			}
		})
		return true;
  }
else
  {
  return false;
  }
});

$(".sends").click(function() {
var item = $(this).attr("namesw");
var price = $(this).attr("priced");
var id = $(this).attr("ids");
		$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'send',
				'weapon': item,
				'price': price,
				'id': id
			},
			success: function(data) {
					if(data.status == 'error'){
					var inst = $('[data-remodal-id=sendfail]').remodal();
					inst.open();
				}
				if(data.status == 'success'){
					sendTrade(data);
				}	
				if(data.status == 'cookie'){
					var inst = $('[data-remodal-id=sendcook]').remodal();
					inst.open();
				}				
			},
			error: function() {
				alert('Произошла ошибка! Попробуйте еще раз или обратитесь к администратору сайта');
			}
		});
		return false;
});
	var socket = io.connect('http://ip:3433');
	function sendTrade(data){
		
		socket.emit('SandTrade', { steamid: data.steam, token: data.details[1], weapon: data.wp, id: data.id, userid: data.uid, pre: data.hash });
		
	}
	socket.on('errorTrade', function (data) {
		var inst = $('[data-remodal-id=errTrade]').remodal();
					inst.open();
					window.setTimeout('location.reload()', 3000); //Reloads after three seconds
	});
	socket.on('succTrade', function (data) {
		var inst = $('[data-remodal-id=sendok]').remodal();
					inst.open();
					window.setTimeout('location.reload()', 3000); //Reloads after three seconds
	});

});
</script>
<div class="opencase nobg">
	<div class="wrap">
		<div class="userprofil" style="margin-top:83px;">
			<div class="lcol">
				<img src="{avatar_f}" alt="" width="186">
				<div class="balance">
					Баланс: <span id="bal">{money}P</span>
				</div>
				<span class="addmoney" style="display: inline-block;">
					<a href="#" onclick="$('#refill_block').arcticmodal();" class="adbal">Пополнить счёт</a>
				</span>	
				<a href="http://steamcommunity.com/profiles/{steam}" class="profsteam" target="_blank">Профиль STEAM</a>
			</div>
			<div class="rcol trade">
				<div>Вы должны указать свою трейд ссылку для отправки предметов. Узнать ее можно <a href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">здесь</a></div>
				<form action="/ajax/" method="post" name="trade" class="rightbutton_block" style="margin-top: 10px;">
					<input name="action" type="hidden" value="saveLink">
					<input type="url" name="url" class="tradelink" placeholder="Пример ссылки: https://steamcommunity.com/tradeoffer/new/?partner=1234567&amp;token=XXXXXXXX" value="{link}">
					<button class="tradebut" name="save">Сохранить</button>
				</form>
			</div>
			<div class="rcol" id="inform">
				<div id="for_load">
					<div class="icon"></div>
					<h5>Дорогие пользователи!</h5>
					<div class="text">
						Остерегайтесь мошенников!<br> 
						Хотим Вас предупредить, что мошенники могут попытаться Вас обмануть.Не поддавайтесь их обещаниям, мы не просим вернуть Ваши вещи обратно и не просим Вас продать вещи за удвоенные суммы. Будьте осторожны, удачи!
						<br>
						<div style="margin-top:10px;">Ответы на часто задаваемые вопросы Вы можете найти на это странице: <a href="/faq">FAQ</a></div>
					</div><br><br>
					<h4>Ваши предметы</h4>
					<div class="opencase-drops nmg">
					{inventory}
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="sendok">
		<h1>Успех</h1>
		<p>
			Ваше оружие успешно отправлено нашим ботом.
			Для получения - подтвердите обмен в Стиме.
			Страница перезагрузится через 4 секунды.
		</p>
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="sendfail">
		<h1>Ошибка</h1>
		<p>
			Возника ошибка. Обратитесь за помощью к администратору.
		</p>
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="sendcook">
		<h1>Ошибка</h1>
		<p>
			Между оправкой оружия должна пройти 1 минута.
		</p>
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="sellok">
		<h1>Успешно</h1>
		<p>
			Предмет продан. Страница перезагрузится через несколько секунд
		</p>
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="errTrade">
		<h1>Ошибка</h1>
		<p>
			К сожалению все наши боты сейчас заняты. Повторите попытку через пару минут.
			Или убедитесь что все требования выполнены, и ссылка на трейд указана верно.
		</p>
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" id="refill_block">
		<form action="/payment/send.php" method="POST" role="form" style="text-align:center;font-size: 17px;">
			<h1 style="font-weight: 600;">Укажите сумму:</h1>
			<input type="text" placeholder="Сумма" id="amount" name="summ" >
			<h1 style="font-weight: 600;">Выберите способ оплаты:</h1>
			<input type="submit" name="wm" value="RoboKassa" class="wm">
			<input type="submit" value="FreeKassa" class="other">
		</form>
	</div>
</div>