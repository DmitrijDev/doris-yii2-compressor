<?php

namespace doris\compressor;

use Tinify\Exception;
use yii\base\Component;

use doris\compressor\Config\CompressorConfig;
use doris\compressor\Services\RequestService;

class Compressor extends Component
{
    public static function compress(CompressorConfig $config): string
    {
        try {

            $config->initConfig();

            if ($config->pathToSave) {
                if (file_exists($config->filePathToSet)) {
                    return $config->returnPath;
                }
            }

            $request = new RequestService();
            $image = $request->getCompressed($config);

            if (!$image) {
                return $config->returnPath;
            }

            file_put_contents($config->filePathToSet, $image);

            if ($config->pathToSave && $config->deleteOriginal) {
                unlink($config->filePathToGet);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $config->returnPath;
    }

}