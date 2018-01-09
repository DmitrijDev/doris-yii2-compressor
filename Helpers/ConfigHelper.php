<?php

namespace doris\compressor\Helpers;

use Yii;

class ConfigHelper
{
	/**
	 * @param int $condition condition of image compress, from 0 to 100
	 * @return array params to send request
	 * @throws \Exception
	 */
    public static function getParams($condition = null)
    {
        $pathHelper = PathHelper::getInstance();
        $key = Yii::$app->params['ImageCompressor']['key'];
        if (empty($key)) {
            throw new \Exception('Can\'t download site key.');
        }

        $file = file_get_contents($pathHelper->filePathToGet);
        if (!$file) {
            throw new \Exception('Can\'t get image.');
        }

        $params = [
            'file' => $file,
            'key' => $key,
            'name' => $pathHelper->name
        ];

        if ($condition) {
            $params['compressed'] = $condition;
        }

        return $params;
    }
}