
<script type="text/javascript"> 
$(document).ready(function(){
	
//Set default open/close settings
$('.faq-a').hide(); //Hide/close all containers
 
//On Click
$('.faq-li').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.faq-li').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	else {
		$('.faq-li').removeClass('active').next().slideUp();
	}
	return false; //Prevent the browser jump to the link anchor
});
 
});
</script>
<style>
	#wrapper {
		min-height: 65%;
	}
</style>
<div class="opencase nobg">
	<div class="opencase nobg">
		<div class="opencase-title">Главная     &gt;     <span>FAQ</span></div>
		<div class="wrap">
			<div class="faq-tlt">FAQ - часто задаваемые вопросы</div>
			<!--#1-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>1. Я открыл кейс и выиграл оружие, но в стиме нет предложения обмена, как быть?</span>
				</div>
				<div class="faq-a">
					Забрать свой предмет можно перейдя в <a href="/user/me">свой профиль,</a> и кликнув на иконку <div class="givedrop"></div>, после чего бот отправит вам предложения обмена, и вы сможете принять свой выигранный предмет.
				</div>
			</div>
			<!--#2-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>2. У меня выскакивает ошибка при попытке забрать предмет с сайта, в чем проблема?</span>
				</div>
				<div class="faq-a">
					<b>Бот может сталкиваться с проблемой при отправке предмета в некоторых случаях:</b>
					<ul>
						<li>Возможно, у вас заблокирован или временно не работает обмен, причиной может стать: недавнее изменение пароля/почты, вы заходили с нового устройства, сменили настройки безопасности или имеете VAC-BAN и т.п. <a href="https://support.steampowered.com/kb_article.php?ref=1047-EDFM-2932&amp;l=russian" target="_blank">Подробнее...</a> Чтобы таких проблем не было, всегда рекомендуем проверять ваш статус трейда.</li>
						<li>Ваш инвентарь не должен быть скрытым, проверьте свои <a href="http://steamcommunity.com/id/me/edit/settings/#inventoryPrivacySetting_private" target="_blank">настройки приватности Steam!</a></li>
						<li>Проверьте ссылку на обмен в <a href="/user/me">профиле</a> и в <a href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">настройках Steam</a> - они должны совпадать!</li>
						<li>Бот столкнулся с проблемой при установке связи с сервисами Steam, сервера сообщества лежат, и бот теряет способность отправлять предметы на некоторое время.</li>
					</ul>
					<i>Внимание! Если вы не заберете свой предмет у бота в течении часа, то вам в профиль вернется полная стоимость этого предмета согласно цене на <a href="http://steamcommunity.com/market/search?appid=730" target="_blank">торговой площадке Steam!</a></i>
				</div>
			</div>
			<!--#3-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>3. На некоторых кейсах есть пометка "Кейс недоступен" и они не работают, почему?</span>
				</div>
				<div class="faq-a">
					Наша цель - предоставить игрокам максимально честный сервис по открытию кейсов и мы хотим обеспечить вас настоящим рандомом! В этом случае, когда вы видите табличку "Кейс недоступен", это говорит о том, что в кейсе не хватает какого-то оружия, и мы вынуждены отключить его. Бот автоматическим образом закупит оружие и как только все нужные предметы для кейса будут у бота в наличии, кейс снова будет доступен для всех!
				</div>
			</div>
			<!--#4-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>4. Я пополнил свой счет на сайте, но деньги так и не пришли, что мне делать?</span>
				</div>
				<div class="faq-a">
					Деньги на счет могут поступать с небольшой задержкой, в зависимости от того, насколько сильно нагружен сервис автооплаты. Если в течении получаса деньги к вам так и не пришли, то напишите нам в <a href="" target="_blank">поддержку</a>, указав все данные вашего платежа.
				</div>
			</div>
			<!--#5-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>5. На моем Steam аккаунте лежат деньги, могу ли я через Steam пополнить счет?</span>
				</div>
				<div class="faq-a">
					Не можете, все доступные способы оплаты указаны на нашей страничке пополнения счета.
				</div>
			</div>
			<!--#6-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>6. В стим меня добавил "модератор\сотрудник" case-up, предлагает купить выигранные вещи. Что делать?</span>
				</div>
				<div class="faq-a">
					Это мошенник, смотрите информацию в вашем <a href="/user/me">личном профиле</a>. МЫ НЕ ДОБАВЛЯЕМ В СТИМЕ! ЭТО ВСЕ ОБМАН! У ВАС УКРАДУТ ВАШИ ПРЕДМЕТЫ.
				</div>
			</div>
			<!--#7-->
			<div class="faq-qa">
				<div class="faq-li">
					<span>7. Могу ли я вывести деньги с сайта?</span>
				</div>
				<div class="faq-a">
					Нет, не можете.
				</div>
			</div>
		</div>
	</div>
</div>