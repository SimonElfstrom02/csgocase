	<head>

		<!-- Basic -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>CASE-UP | Кейсы CS:GO по самым низким ценам!</title>
		<meta name="description" content="Кейсы CS:GO по самым низким ценам! Выше шанс выпадения хороших вещей!">
		<meta name="keywords" content="case csgo, кейсы cs go, кейс кс го, csgo-free, open case, easydrop, cs go ru, cases pro, бесплатное оружие кс">

		<!-- Mobile Metas -->
		<link rel="shortcut icon" href="/template/img/favicon.ico">
		<meta name="viewport" content="width=1900px, initial-scale=1, minimum-scale=1, user-scalable=no" />
		
		<script type="text/javascript" src="/template/js/jquery.js"></script>
		<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
		<script type="text/javascript" src="/template/js/jquery-ui.min.js"></script>

		<script type="text/javascript" src="/template/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="/template/js/scrolling-nav.js"></script>
		<script type="text/javascript" src="/template/js/jquery.noty.packaged.js"></script>
		<script type="text/javascript" src="/template/js/jquery.fittext.js"></script>
		<script type="text/javascript" src="/template/js/cycle.js"></script>
		
		<script type="text/javascript" src="/template/js/jquery.tooltipster.min.js"></script>
		
		<link rel="stylesheet" href="/template/css/jquery.remodal.css">
		<script src="/template/js/jquery.remodal.js"></script>
		
		<!-- Модальное окно -->
		<script type="text/javascript" src="/template/js/jquery.arcticmodal-0.3.min.js"></script>
		<link rel="stylesheet" href="/template/css/arcticmodal.css">
		
		<!--CSS -->
		<link rel="stylesheet" href="/template/css/style.css" />
		<link rel="stylesheet" href="/template/css/media.css" />
		<link href="//fonts.googleapis.com/css?family=Play:400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
		
		<script>
	var caseOpenAudio = new Audio();
    caseOpenAudio.src = "/template/audio/open.wav";
    caseOpenAudio.volume = 0.2;

    var caseCloseAudio = new Audio();
    caseCloseAudio.src = "/template/audio/close.wav";
    caseCloseAudio.volume = 0.2;
	
	var caseScrollAudio = new Audio();
    caseScrollAudio.src = "/template/audio/scroll.wav";
    caseScrollAudio.volume = 0.2;
	var socketf = io.connect('http://ip:3433');
	
	socketf.on('users connected', function (data) {
		$('#onlined').html(data);

		});
	socketf.on('loadLastWin', function (data) {
		var last = '<a href="/user/'+data.userid+'" class="item-history '+data.type+'">'
				+'<img src="'+data.img+'/360x360f">'
				+'<div class="live-line-item-tooltip">'
				+'<div class="live-line-item-tooltip-line"></div>'
				+'<div class="live-line-item-tooltip-block">'
				+'<div class="live-line-item-tooltip-block-source"><img src="'+data.caseimg+'" height="80" width="111" alt=""></div>'
				+'<div class="live-line-item-tooltip-block-nick">'+ data.username +'</div>'
				+'<div class="live-line-item-tooltip-block-item">'+data.weaponname+'</div>'
				+'</div>'
				+'</div>'
				+'</a>';	
		$('#live').prepend(last);
		$(last).fadeIn(1000);
		//
		var n = $("#opcase").text();
		$('#opcase').html((parseInt(n)) + 1);

	});
    $(function () {
	   $(".button.refill").click(function(){
			document.getElementById('amount').value = document.getElementById('invoiceMoney').value;
			$('#refill_block').arcticmodal();
       });
   })

		</script>
		
	</head>
	