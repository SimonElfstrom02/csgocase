<?php
class System_top extends connect
{
	function tops(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `users` ORDER BY profit DESC LIMIT 3");
		
		foreach ($data as $row){
			//$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
			$avatar = str_replace("medium", "full", $row['avatar']);;
			$type = $row['type'];
			$top_three++;
			if($top_three == 1) {
				$topnum = 'top1';
			}
			if($top_three == 2) {
				$topnum = 'top2';
			}
			if($top_three == 3) {
				$topnum = 'top3';
			}
			$el .= '<div class="lucky '.$topnum.'">
				<div class="'.$topnum.'"></div>
				<a href="/user/'.$row['id'].'"><img src="'.$avatar.'" alt="">
				<div class="name">'.$row['name'].'</div></a>
				<div class="col lcol"><strong style="color: #4380BC;">'.$row['cases'].'</strong> кейсов</div>
				<div class="col rcol"><strong>'.$row['profit'].' P</strong> профит</div>
			</div>';
		}
		return $el;
	}

	function topses(){
		$top_three = 3;
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `users` ORDER BY profit DESC LIMIT 3, 17");
		
		foreach ($data as $row){
			//$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
			$avatar = str_replace("medium", "full", $row['avatar']);;
			$type = $row['type'];
			$top_three++;
			$el .= '<div class="userline">
				<div class="one" style="color:#DDB401;">'.$top_three.'</div>
				<div class="two"><a href="/user/'.$row['id'].'" style="color: #D43C39;"><img src="'.$row['avatar'].'" height="30" width="115" alt="">'.$row['name'].'</a></div>
				<div class="three" style="color:#4380BC;">'.$row['cases'].'</div>
				<div class="four">'.$row['profit'].' P</div>
			</div>';
		}
		return $el;
	}

	function action_index()
	{
		return array($this->tops(),$this->topses());
	}
} 