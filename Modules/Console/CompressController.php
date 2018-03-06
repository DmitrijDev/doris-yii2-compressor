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

        $compressed_files_count = 0;
        $error_files_count = 0;
        foreach ($collection as $image) {
            $image = str_replace($fronted, '', $image);
            $image = str_replace('\\', '/', $image);
            $image = trim($image, '\\');
            $image = trim($image, '/');


            if ($this->compressImage($image, $compressor)) {
                $compressed_files_count++;
            } else {
                $error_files_count++;
            };
        }


        $count_of_files = count($collection);

        $this->pushMessage("\nFinish. Files count {$count_of_files}. \nCompressed files: {$compressed_files_count}. \nError files: {$error_files_count}");
    }

    private function compressImage($image, CompressorApi $compressor)
    {
        try {
            $compressor->setPathToImage($image);
            $compressor->compress();

            $this->pushMessage("Image {$image} was compressed");
            return true;
        } catch (Exception $e) {
            $this->pushMessage($e->getMessage());
            return false;
        }
    }

    private function pushMessage($message = '')
    {
        echo $message . "\n";
    }
}