<?php
class System_profile extends connect
{
	
	function links(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$_SESSION['id']}'");
		
		return $data['link'];
	}
	
	function money(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$_SESSION['id']}'");
		
		return $data['money'];
	}
	
	function img_full(){
		$ava = $_SESSION['avatar'];
		$av = str_replace("medium", "full", $ava);
		
		return $av;
	}
	
	function inventory(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `inventory` WHERE `user`='{$_SESSION['id']}' ORDER BY `id` DESC");
		
		foreach ($data as $row){
			$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
			$full_name = $row['weapon'].' | '.$row['second'];
			$type = $row['type'];
			if($row['status'] == 'completed') {
				$status = '<div class="active" title="Получено"></div>';
				$sell = '';
				$send = '';
			}
			if($row['status'] == 'progress'){
				 $status = '';
				 $sell = '<div class="tosell view"  ids="'.$row['id'].'" imgw="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'" case="'.$row['case'].'" title="Продать за '.$row['price'].'P"></div>';
				$send = '<div class="sends out" ids="'.$row['id'].'" priced="'.$row['price'].'" namesw="'.$row['weapon'].' | '.$row['seconden'].'" title="Забрать предмет"></div>';
			}
			if($row['status'] == 'selled') {
				$status = '<div class="view" title="Продано"></div>';
				$sell = '';
				$send = '';
			}
			if($row['status']=='notcompleted'){
				$status = '';
				$sell = '<div class="tosell view"  ids="'.$row['id'].'" imgw="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'" case="'.$row['case'].'" title="Продать за '.$row['price'].'P"></div>';
				$send = '<div class="sends out" ids="'.$row['id'].'" priced="'.$row['price'].'" namesw="'.$row['weapon'].' | '.$row['seconden'].'" title="Забрать предмет"></div>';
			}
			$el .= '<div class="opencase-drops-one">
	<div class="drops-status">
		<div class="coast">'.$row['price'].'P</div>	
		'.$sell.'
		'.$status.'
		'.$send.'
	</div>
	<div class="opencase-drops-one-image" id="profileimage" style="background-image:url(https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].')">
		<a href="#"><img src="'.$cs['img'].'" style="height: 80px;margin-top: 6px;"></a>
	</div>
	<div class="opencase-drops-one-text '.$type.'">
		<div>'.$row['weapon'].'</div>
		<div>'.$row['second'].'</div>
	</div>
</div>';
		}
		return $el;
	}
	
	function action_index()
	{
		return array($this->links(), $this->money(), $this->img_full(), $this->inventory());
	}
} 