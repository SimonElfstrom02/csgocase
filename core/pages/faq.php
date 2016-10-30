<?php

class Page_faq extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"faq", 
			array(
				'{32}' => NULL
			)
		);
	}
}