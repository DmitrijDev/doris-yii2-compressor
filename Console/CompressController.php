<?php

namespace doris\compressor\console;

use doris\compressor\Compressor;
use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

class CompressController extends Controller
{
	private $frontend = '.\frontend\web';

	public function actionIndex($path = null, $recursive = true)
	{
		$dir = $this->frontend . $path;
		if (!$path || !file_exists($dir)) {
			$this->pushMessage("Directory {$dir} not exist");
			return;
		}

		$this->pushMessage("Start compressing... \n");
		Yii::setAlias('@web', $this->frontend);
		Yii::setAlias('@webroot', $this->frontend);

		$collection = FileHelper::findFiles($dir, [
			'only' => ['*.png', '*.jpg'],
			'recursive' => filter_var($recursive, FILTER_VALIDATE_BOOLEAN)
		]);

		$comp = new Compressor();
		foreach ($collection as $image) {
			$file = str_replace($this->frontend, '', $image);

			$comp->compress($file);
			$this->pushMessage("Image {$image} is now compressed \n");
		}

		$count_of_files = count($collection);

		$this->pushMessage("Finish. Compressed {$count_of_files} files.");
	}

	private function pushMessage($message = '')
	{
		echo $message;
	}
}