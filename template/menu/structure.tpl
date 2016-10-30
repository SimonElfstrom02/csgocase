<!DOCTYPE html>
<html lang="ru">
	<head>
		{head}
	</head>
	<body>
	<script>
		$(function(){
		    var loc = window.location.search;
		    if(loc == "?yes"){
		    	var ord = $('[data-remodal-id=ok]').remodal();
		        ord.open();
		    }
		    if(loc == "?no"){
		    	var ord = $('[data-remodal-id=fail]').remodal();
		        ord.open();
		    }
		})
	</script>
	<div id="wrapper">
	<header>
	<div class="anime_head"></div>
		<div class="wrap">
			<a href="/" id="logo">CASE-UP</a>
			<ul id="tnav">
				<li><a href="/">Главная</a></li>
				<li><a href="/faq">F.A.Q.</a></li>
				<li><a href="/top">ТОП</a></li>
				<li><a href="/reviews">Отзывы</a></li>
				<li><a href="" target="_blank" class="vk">Мы Вконтакте</a></li>
			</ul>
			{profile}
		</div>

		<div class="drophistory">
			<div class="headline">
				<span style="background: linear-gradient(#CAC8C8, #fff);-webkit-background-clip: text;color: transparent;">Live-дропы:</span>
			</div>
			<div class="items">
				<div id="live">
					{last}				
				</div>
			</div>
		</div>
	</header>
	{content}
</div>
<footer>
	<div id="stats-bg">
		<div class="wrap">
			<div id="community">
				<a href="" target="_blank" class="soc" id="vk"></a>
				<a href="" target="_blank" class="soc" id="mail"></a>
			</div>
						<div id="site-info">
				<div class="row">
					<strong id="opcase">{opens}</strong>
					<small>ОТКРЫТО КЕЙСОВ</small>
				</div>
				<div class="row">
					<strong>{users}</strong>
					<small>пользователей</small>
				</div>
				<div class="row">
					<strong id="onlined">34</strong>
					<small>онлайн</small>
				</div>
			</div>
		</div>
	</div>
	<div class="wrap">
		<div class="lorem">
			CASE-UP | Магазин кейсов CS:GO <br>
			Открывайте кейсы с выгодой и дешевле чем в STEAM <br>
			Все обмены происходят в автоматическом режиме с помощью ботов<br><br>
			<div class="clr"></div>
		</div>
	</div>
</footer>
</div>
	
	</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="ok">
		<h1>Успешно</h1>
		<p>
			Ваш баланс успешно пополнен. Удачи =)
		</p>
	</div>
</div>
<div style="display: none;" class="remodal-bg">
	<div class="remodal" data-remodal-id="fail">
		<h1>Неудача</h1>
		<p>
			Ошибка при пополнении баланса. Обратитесь за помощью к администратору.
		</p>
	</div>
</div>
		
	</body>
</html>