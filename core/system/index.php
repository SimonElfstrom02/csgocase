<?php
class System_index extends connect
{
	
	function get_case(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `cases` WHERE `var`='case'");
		
		foreach ($data as $row){
			$stat = '';
			$link = 'href="/?case='.$row['name'].'"';
			$stat2 = 'Подробнее';
			if($row['status'] == 0){
				$stat = 'style="opacity: 0.4;"';
				$stat2 = 'Кейс недоступен';
				$stat3 = '';
			}else {
				$stat2 = ''.$row['disp_name'].'';
				$stat3 = 'href="/?case='.$row['name'].'"';
			}
			$el .= '<a '.$stat3.' class="case">
			<i class="box"><img src="'.$row['img'].'" '.$stat.'></i>
			<span '.$stat.'>'.$stat2.'</span>
			<strong '.$stat.'>'.$row['price'].' P</strong>
		</a>';
		}
		return $el;
	}

	function get_col(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `cases` WHERE `var`='col'");
		
		foreach ($data as $row){
			$stat = '';
			$link = 'href="/?case='.$row['name'].'"';
			$stat2 = 'Подробнее';
			if($row['name'] == 'Assault'){
				$mt = 'margin-top:20px;';
			}else{
				$mt = '';
			}
			if($row['status'] == 0){
				$stat = 'style="opacity: 0.4;'.$mt.'"';
				$stat2 = 'Кейс недоступен';
				$stat3 = '';
			}else {
				$stat2 = ''.$row['disp_name'].'';
				$stat3 = 'href="/?case='.$row['name'].'"';
			}
			$el .= '<a '.$stat3.' class="coll">
			<i class="box"><img src="'.$row['img'].'" '.$stat.'></i>
			<span '.$stat.'>'.$stat2.'</span>
			<strong '.$stat.'>'.$row['price'].' P</strong>
		</a>';
		}
		return $el;
	}

	function get_kases(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `cases` WHERE `var`='kases'");
		
		foreach ($data as $row){
			$stat = '';
			$top = 'margin-top: 15px;';
			$stat2 = 'Подробнее';
			if($row['status'] == 0){
				$stat = 'style="opacity: 0.4;'.$top.'"';
				$stat2 = 'Кейс недоступен';
				$stat3 = 'Недоступно';
				$stat4 = '';
			}else {
				$stat = 'style="margin-top:15px;"';
				$stat2 = ''.$row['disp_name'].'';
				$stat3 = 'Открыть';
				$stat4 = 'href="/?case='.$row['name'].'"';
			}
			$el .= '<a '.$stat4.' class="randbox '.$row['type'].'">
			<i class="box"><img src="'.$row['img'].'" '.$stat.'></i>
			<span '.$stat.'>'.$stat2.'</span>
			<strong '.$stat.'>'.$row['price'].' P</strong>
			<span class="view">'.$stat3.'</span>
		</a>';
		}
		return $el;
	}
	
	function get_case2(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `cases` WHERE `var`='case2'");
		
		foreach ($data as $row){
			$stat = '';
			
			$stat2 = 'Подробнее';
			if($row['status'] == 0){
				$stat = 'style="opacity: 0.4"';
				$stat2 = 'Кейс недоступен';
				$stat3 = 'Недоступно';
				$stat4 = '';
			}if($row['name'] == 'Glock Case'){
				$stat2 = ''.$row['disp_name'].'';
				$stat3 = 'Открыть';
				$stat4 = 'href="/?case='.$row['name'].'"';
				$stat5 = 'style="margin-left:12%;"';
			}else {
				$stat2 = ''.$row['disp_name'].'';
				$stat3 = 'Открыть';
				$stat4 = 'href="/?case='.$row['name'].'"';
				$stat5 = '';
			}
			$el .= '<a '.$stat4.' class="randbox '.$row['type'].'" '.$stat5.'>
			<i class="box"><img src="'.$row['img'].'" '.$stat.'></i>
			<span '.$stat.'>'.$stat2.'</span>
			<strong '.$stat.'>'.$row['price'].' P</strong>
			<span class="view">'.$stat3.'</span>
		</a>';
		}
		return $el;
	}
	
	function get_cat(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `cases` WHERE `var`='cat'");
		
		foreach ($data as $row){
			$stat = '';
			
			$stat2 = 'Подробнее';
			if($row['status'] == 0){
				$stat = 'style="opacity: 0.4"';
				$stat2 = 'Кейс недоступен';
				$stat3 = 'Недоступно';
				$stat4 = '';
			}else{
				$stat2 = ''.$row['disp_name'].'';
				$stat3 = 'Открыть';
				$stat4 = 'href="/?case='.$row['name'].'"';
			}
			$el .= '<a '.$stat4.' class="randbox '.$row['type'].'">
		<i class="box"><img src="'.$row['img'].'" '.$stat.'></i>
		<span '.$stat.'>'.$stat2.'</span>
		<strong '.$stat.'>'.$row['price'].' P</strong>
		<span class="view">'.$stat3.'</span>
		</a>';
		}
		return $el;
	}
	
	function action_index()
	{
		return array($this->get_case(), $this->get_cat(),$this->get_case2(),$this->get_col(),$this->get_kases());
	}
} 