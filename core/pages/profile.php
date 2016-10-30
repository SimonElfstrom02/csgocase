<?php

class Page_profile extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"profile", 
			array(
				"{link}" => $param[0],
				"{name}" => $_SESSION['name'], 
				"{avatar_f}" => $param[2], 
				"{money}" => $param[1],
				"{steam}" => $_SESSION['steamid'],
				"{inventory}" => $param[3]
			)
		);
	}
}