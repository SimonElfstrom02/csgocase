<?php

class Page_index extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"main", 
			array(
				"{cases}" => $param[0],
				"{cases2}" => $param[2],
				"{cat}" => $param[1],
				"{col}" => $param[3],
				"{kases}" => $param[4]
			)
		);
	}
}