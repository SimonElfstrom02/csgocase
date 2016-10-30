<?php

class Page_top extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"top", 
			array(
				"{tops}" => $param[0],
				"{topses}" => $param[1]
			)
		);
	}
}