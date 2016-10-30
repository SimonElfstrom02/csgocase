<script type="text/javascript" src="/template/js/jquery.js"></script>
<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
<?php
session_start();
include '/var/www/config.php';
	$db = mysql_connect('host','user','pass');
	mysql_select_db('db',$db);
	
	$time = time();
	#mysql_query("INSERT INTO `cron`(`id`, `userid`, `weapon`, `price`, `time`) VALUES (NULL,25,'olo',10,'".date('Y-m-d H:i:s')."')");

	
	
	$sql = "SELECT * FROM `cron` WHERE `status` = 'wait'";
	
	$query = mysql_query($sql, $db);
	while($row = mysql_fetch_array($query)){
		//$sql2 = mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$row['idw']}'");
		//$row2 = mysql_fetch_array($sql2);
		
		if( $row['time'] <= date('Y-m-d H:i:s') ) 
		{ 
			echo "
			<script>
			var socketf = io.connect('ip');
			$(document).ready ( function(){	
				socketf.emit('declOffer', { 
						ids: '".$row['offerid']."'
					});
			});
			</script>
			"; 
			mysql_query("UPDATE `inventory` SET `status` = 'expir' WHERE `idw` = '{$row['idw']}'");
		} 
		else 
		{ 
			echo 'Fail';
		}
		
	}
?>