<?php

class Page_reviews extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"reviews", 
			array(
				'{32}' => NULL
			)
		);
	}
}