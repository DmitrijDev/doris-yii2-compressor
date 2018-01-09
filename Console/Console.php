<?php

namespace doris\compressor\console;

use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\console\Application;


class Console extends Module implements BootstrapInterface
{
	public $controllerNamespace = 'doris\compressor\console';
	public $defaultRoute = 'compress';

	public function init()
	{
		parent::init();
	}

	public function bootstrap($app)
	{
		if ($app instanceof Application) {
			$this->controllerNamespace = 'doris\compressor\console';
		}
	}
}