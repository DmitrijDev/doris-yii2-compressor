<?php

namespace doris\compressor\modules\console;

use Tinify\Exception;
use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;
use doris\compressor\CompressorApi;

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

        try {
            $compressor = new CompressorApi();
            foreach ($collection as $image) {
                $image = str_replace($this->frontend, '', $image);

                $compressor->setPathToImage($image);

                if ($compressor->compress()) {
                    $this->pushMessage("Image {$image} is now compressed \n");
                }
            }
        } catch (Exception $e) {
            $this->pushMessage($e->getMessage());
        }

        $count_of_files = count($collection);

        $this->pushMessage("Finish. Compressed {$count_of_files} files.");
    }

    private function pushMessage($message = '')
    {
        echo $message;
    }
}