<?php

namespace doris\compressor\Modules\Console;

use Yii;
use Exception;
use yii\console\Controller;
use yii\helpers\FileHelper;
use doris\compressor\CompressorApi;

class CompressController extends Controller
{
    private $frontendAdvanced = './frontend/web';
    private $frontendBasic = './web';

    public function actionIndex($path = null, $recursive = true)
    {
        $fronted = file_exists($this->frontendAdvanced) ? $this->frontendAdvanced : $this->frontendBasic;

        $dir = $fronted . $path;
        if (!$path || !file_exists($dir)) {
            $this->pushMessage("Directory {$dir} not exist");
            return;
        }

        $this->pushMessage("Start compressing...");
        Yii::setAlias('@webroot', $fronted);

        $collection = FileHelper::findFiles($dir, [
            'only' => ['*.png', '*.jpg'],
            'recursive' => filter_var($recursive, FILTER_VALIDATE_BOOLEAN)
        ]);

        $compressor = new CompressorApi();
        foreach ($collection as $image) {
            $image = str_replace($fronted, '', $image);

            $this->compressImage($image, $compressor);
        }


        $count_of_files = count($collection);

        $this->pushMessage("Finish. Compressed {$count_of_files} files.");
    }

    private function compressImage($image, CompressorApi $compressor)
    {
        try {
            $compressor->setPathToImage($image);
            $compressor->compress();

            $this->pushMessage("Image {$image} was compressed");
        } catch (Exception $e) {
            $this->pushMessage($e->getMessage());
        }
    }

    private function pushMessage($message = '')
    {
        echo $message . "\n";
    }
}