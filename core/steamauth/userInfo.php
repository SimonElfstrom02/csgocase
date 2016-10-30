<?php
	include("settings.php");
        $urljson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']);
		$data = (array) json_decode($urljson)->response->players[0];
		
		$_SESSION['name'] = $data['personaname'];
		$_SESSION['avatar'] = $data['avatarmedium'];
		echo $data['personaname'];
?>
    
