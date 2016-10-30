<?php
class connect extends DATABASE
{
	public $config;
	function __construct()
	{
		include BASE_URL . "/config.php"; $this->config = $config;
		parent::__construct("mysql:host={$config['db']['host']};dbname={$config['db']['base']}", $config['db']['user'], $config['db']['pass']);
		if ($_SESSION['auth']) {
			
			$row = $this->__fetch("SELECT * FROM `users` WHERE `steam` = '{$_SESSION['steamid']}'");
			
			$_SESSION['id'] = $row['id'];
			
			$_SESSION['auth'] = true;
		}
	}
}