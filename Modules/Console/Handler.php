<?php

namespace doris\compressor\Modules\Console;

use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\console\Application;


class Handler extends Module implements BootstrapInterface
{
	public $controllerNamespace = 'doris\compressor\Modules\Console';
	public $defaultRoute = 'compress';

	public function init()
	{
		parent::init();
	}

	public function bootstrap($app)
	{
	}
}