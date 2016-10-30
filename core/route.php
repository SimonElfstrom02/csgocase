<?php
class Route
{
	static function start($page = "index", $main = "index")
	{
		if (empty($main)) $main = "index"; 
		if (empty($page)) $page = "index"; 
		$main = strtolower($main); 
		$page = strtolower($page);
		if (
			!defined('BASE_URL') 
			|| $page == '404' 
			|| !file_exists(BASE_URL . '/core/system/' . $page . '.php')
			|| !file_exists(BASE_URL . '/core/pages/' . $page . '.php')
		) 
		{
			return Route::Page404();
		}
		require BASE_URL . '/core/system/' . $page . '.php';
		$func = "action_".$main;
		$system_class = "System_".$page;
		$page_class = "Page_".$page; 
		$system = new $system_class(); 
		if(method_exists($system, $func)) {
			require BASE_URL . '/core/pages/' . $page . '.php';
		} else {
			return Route::Page404();
		}
		$page = new $page_class(); 
		return $page->$func($system->$func());
	}
	
	static function Page404()
	{
		return set("errors/404", array("{img}" => rand(2,3)));
	}
}
?>