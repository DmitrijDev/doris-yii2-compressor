<?php

namespace doris\compressor;

use Yii;
use yii\base\Component;

use doris\compressor\Helpers\PathHelper;
use doris\compressor\Helpers\ConfigHelper;
use doris\compressor\Services\RequestService;

class Compressor extends Component
{

    public function compress($img, $path = false, $condition = null)
    {
        $pathHelper = PathHelper::getInstance();
        $pathHelper->setData($img, $path);

        $config = ConfigHelper::getParams($condition);

        if ($path) {
            if (file_exists($this->pathHelper->filePathToSet)) {
                return $this->pathHelper->returnPath;
            }
        }

        $request = new RequestService();
        $image = $request->getCompressed($config);

        if (!$image) {
            return $img;
        }

        if (!$path) {
            file_put_contents($pathHelper->filePathToSet, $image);
            return $img;
        }

        file_put_contents($pathHelper->filePathToSet, $image);

        return $pathHelper->returnPath;
    }

}