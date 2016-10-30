<?php

class Page_agreement extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"agreement", 
			array(
				'{32}' => NULL
			)
		);
	}
}