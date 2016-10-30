<?php
class DATABASE extends PDO
{
	private $pdo_conn;
	
	private $pdo_user;

	private $pdo_pass;
	
	public function __construct($pdo_conn, $pdo_user, $pdo_pass)
	{
		parent::__construct($pdo_conn, $pdo_user, $pdo_pass); //mysql:host=$host;dbname=$dbname
		$this->query("SET NAMES UTF8");
	}
	
    function user($user, $column = "id")
    {
        $fetch = $this->prepare("SELECT * FROM `users` WHERE `{$column}` = ?");
        $fetch->execute(array($user));
        $data = $fetch->fetch(PDO::FETCH_ASSOC);
		return $data;
    }
	
	public function _prepare($sql, $binds)
	{
		$prepare = $this->prepare($sql);
		return $prepare->execute($binds);
	}
	
	public function _fetch($sql, $binds)
	{
		$prepare = $this->prepare($sql);
		$prepare->execute($binds);
		$fetch = $prepare->fetch(self::FETCH_ASSOC);
		return $fetch;
	}
	
	public function __fetch($sql)
	{
		$query = $this->query($sql);
		$fetch = $query->fetch(self::FETCH_ASSOC);
		return $fetch;
	}
	
	public function _rows($sql, $binds)
	{
		$prepare = $this->prepare($sql);
		$prepare->execute($binds);
		$num = $prepare->rowCount();
		return $num;
	}
	
	public function __rows($sql)
	{
		$query = $this->query($sql);
		$num = $query->rowCount();
		return $num;
	}
	
	public function _money($operation, $amount, $user)
	{
		$prepare = $this->prepare("UPDATE `users` SET `money` = `money` {$operation} ? WHERE `id` = ?");
		return $prepare->execute(array($amount, $user));
	}
}
