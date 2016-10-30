<div class="bar">
						<nav>
							<a class="button active" href="settings.php">Настройки</a>
						</nav>
					</div>
					<script>
					function SaveLink() {
				$.ajax({
					'url': "/index.php?ajax=savelink",
					'type': 'POST',
					'dataType': "html",
					'data': $("#save").serialize(), 
					'success': function(response) {
						location.href = "/?page=settings";
					},
					'error': function(response) {
						alert('Возникла ошибка, обратитесь пожалуйста к администратору');
					}
				});
			}
			</script>
					<div class="figure">
						<p>
							Чтобы мы могли Вам отправить выигранные Вами предметы, Вы должны включить функцию Offline Trade Offer в настройках Вашей учётной записи Steam.
						</p>
						<p>
							<a class="red" href="https://steamcommunity.com/my/tradeoffers/privacy" target = "_blank">Узнайте Ваш личный трейд-офер</a> в сериве Steam, а затем введите его в поле ввода.
						</p>
						<p>
						<form id="save" method = "POST">
							<table>
								<tbody>
								<tr>
									<td>Трейд-оффер:</td>
									<td><input type="text" name="link" value="{link}" /></td>
								</tr>
								<tr>
									<td></td>
									<td><button onclick="SaveLink();" type="button" class="button main" name="send" />Сохранить изменения</button></td>
								</tr>
								</tbody>
							</table>
						</form>
						</p>
					</div>