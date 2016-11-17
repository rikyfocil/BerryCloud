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
            'class' => "fileListForm"
		]);
		echo FormFacade::submit($submit, [
			'class' => "btn btn-block btn-default" . $class
		]);
		echo FormFacade::close();
	}

	static function createButtonWithIcon($method, $route, $submit = "submit" , $class = "", $icon="", $tip="")
	{
		echo FormFacade::open([
			'method' => $method,
			'route' => $route,
            'class' => "fileListForm"
		]);
        echo FormFacade::button('<span class="glyphicon '. $icon . '"></span>', 
            array('class'=>'btn btn-default' . $class, 
            'type'=>'submit', 'data-toggle'=>'tooltip', 'data-placement'=>'bottom','title'=>''.$submit));
		echo FormFacade::close();
	}

	static function createButtonAction($method, $route, $submit = "submit" , $class = "")
	{
		echo FormFacade::open([
			'method' => $method,
			'route' => $route,
            'class' => "fileListFormAction"
		]);
		echo FormFacade::submit($submit, [
			'class' => "btn action-button" . $class
		]);
		echo FormFacade::close();
	}
}
