<script>
$(document).ready ( function(){	
$('.quit').click(function(){
event.preventDefault();
window.location.href = 'http://site.ru/?logout';
});
});
</script>	
<div id="autorize">				
	<a class="profil" href="/user/me">
		<span class="lcol img"><img src="{avatar}" alt=""></span>
		<span class="lcol text">
			<span class="name">{name}</span>
			<span class="mon">Баланс: <span id="bal">{money}</span> Р</span>
		</span>
	</a>
	<a class="quit rcol logout" title="Выйти из профиля">x</a>					
</div>