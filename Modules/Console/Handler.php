<?php

namespace doris\compressor\modules\console;

use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\console\Application;


class Handler extends Module implements BootstrapInterface
{
	public $controllerNamespace = 'doris\compressor\modules\console';
	public $defaultRoute = 'compress';

	public function init()
	{
		parent::init();
	}

	public function bootstrap($app)
	{
		if ($app instanceof Application) {
			$this->controllerNamespace = 'doris\compressor\modules\console';
		}
	}
}