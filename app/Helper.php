<?php

namespace App;
use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;

class Helper
{

	static function createButton($method, $route, $submit = "submit" , $class = "")
	{
		echo FormFacade::open([
			'method' => $method,
			'route' => $route,
		]);
		echo FormFacade::submit($submit, [
			'class' => "btn btn-block " . $class
		]);
		echo FormFacade::close();
	}
}
