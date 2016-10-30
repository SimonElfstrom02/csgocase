<?php
session_start();
define("BASE_URL", __DIR__);

include './config.php';

//define("BASE_URL", __DIR__);

//require BASE_URL . '/core/steamauth/userInfo.php';

class Page
{	
	private function Menu($align) 
	{
		//include BASE_URL."Application/include/menu.php";
		foreach ($menu[$align] as $element => $parm)
		{
			if (count($parm) > 2) {
				if($parm['group'] <= $_SESSION['info'][GROUP] || $parm['group'] == 0) {
					$return .= set("menu/dropdown", array("{text}" => $parm['text'], "{elements}" => Page::MenuFor($parm)));
				}
			} else {
				if($parm['group'] <= $_SESSION['info'][GROUP] || $parm['group'] == 0) {
					$exp = explode("/", $_SERVER['REQUEST_URI']);
					$return .= set(
						"menu/element", 
						array(
							"{text}" => $parm['text'], 
							"{href}" => $element, 
							"{class}"=> ($exp[1] == str_replace("/", NULL, $element)) ? "active" : NULL
						)
					);
				}
			}
		}
		return $return;
	}
	
	private function MenuFor($params)
	{
		unset($params['text']);
		unset($params['group']);
		foreach ($params as $key => $param)
		{
			if($param['group'] <= $_SESSION['info'][GROUP] || $param['group'] == 0) {
				$return .= set(
					"menu/element", 
					array(
						"{text}" => $param['text'],
						"{href}" => $key,
						"{class}" => (str_replace("/", NULL, $_SERVER['REQUEST_URI']) == str_replace("/", NULL, $key)) ? "active" : NULL
					)
				);
			}
		}
		return $return;
	}
	
    static function generate($content, $action = "index", $case, $id)
    {
		if(isset($case)){
			//$content = $case;
			/*$cases = set("case", array(
				"{case}" => $case
			));*/
			$case = str_replace(" ", "%20", $case);
			//$content = '<div class="preloader" style="display: block;"><div><img src="/template/img/preloader.GIF"></div></div><script>$("#content").load("/case/case.php?c='.$case.'");</script>';
			$content = file_get_contents ( 'http://site.ru/case/case.php?c='.$case );
		}
		if($id > 0){
			$content = file_get_contents ( 'http://site.ru/profile.php?id='.$id );
		}
		include(BASE_URL . '/core/steamauth/steamauth.php');
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
  
		$head = set("menu/head", array("{title}" => $title[str_replace("/", NULL, $_SERVER['REQUEST_URI'])]));
		
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$_SESSION['id']}'");
		$opens = $pdo->__fetch("SELECT * FROM `stats`");
		
		if($_SESSION['auth']){
		$profile = set("menu/profile", array(
		"{name}" => $_SESSION['name'], 
		"{avatar}" => $_SESSION['avatar'], 
		"{money}" => $data['money']
		));
		}else{
		$profile = set("menu/profile_nonlogin", array(
		"{name}" => ''
		));
		}
		/////BAN///////
		if($data['ban'] == 1) { 
			header('Location: http://natribu.org');
			exit();
		}
		//////BAN//////
		/////FREE//////
		if($data['free'] == 0) {
			$pdo->query("UPDATE `users` SET `free` = 1 WHERE `steam`='{$_SESSION['steamid']}'");
			$pdo->query("UPDATE `users` SET `money` = `money` + 1 WHERE `steam`='{$_SESSION['steamid']}'");
		}
		/////FREE//////
		$last = $pdo->query("SELECT * FROM `last` ORDER BY `id` DESC limit 16");
		while ($row = $last->fetch())
		{
			
			$fd .= '<a href="/user/'.$row['userid'].'" class="item-history '.$row['type'].'">
			<img src="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'/360x360f">
			<div class="live-line-item-tooltip">
			<div class="live-line-item-tooltip-line"></div>
			<div class="live-line-item-tooltip-block">
			<div class="live-line-item-tooltip-block-source"><img src="'.$row['imgcase'].'" height="80" width="111" alt=""></div>
			<div class="live-line-item-tooltip-block-nick">'.$row['username'].'</div>
			<div class="live-line-item-tooltip-block-item">'.$row['weapon'].'</div>
			</div>
			</div>
			</a>'; 
			
			
		}
	
		$usersd = $pdo->query("SELECT * FROM `users`");

		//$fetch = $this->query("SELECT * FROM `pc_notific` ORDER BY `id` DESC LIMIT 0, 5")->fetchAll();
		//$note = set("menu/notific", array("{title_d}" => $fetch['title'], "{text}" => $fetch['desc']));
		echo set("menu/structure", array(
		"{last}" => $fd,
		"{name}" => $_SESSION['name'],
		"{opens}" => $opens['cases'],	
		"{users}" => $usersd->rowCount(),	
		"{avatar}" => $_SESSION['avatar'], 
		"{money}" => $data['money'],
		"{profile}" => $profile, "{head}" => $head, "{menu}" => $menu, "{content}" => $content));
		
    }
}
?>