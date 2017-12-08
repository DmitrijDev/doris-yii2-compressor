<?php

namespace doris\compressor;

use Yii;
use yii\base\Component;

use doris\compressor\Helpers\PathHelper;
use doris\compressor\Helpers\ConfigHelper;
use doris\compressor\Services\RequestService;

class Compressor extends Component
{

    private $pathHelper;

    public function init()
    {
        $this->pathHelper = new PathHelper();
    }

    public function compress($img, $path = false, $condition = null)
    {
        $this->pathHelper->setData($img, $path);
        $config = ConfigHelper::getParams($this->pathHelper, $condition);

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
            file_put_contents($this->pathHelper->filePathToSet, $image);
            return $img;
        }

        file_put_contents($this->pathHelper->filePathToSet, $image);

        return $this->pathHelper->returnPath;
    }

    public function setAlias($alias)
    {
        $this->pathHelper->setAlias($alias);
    }

}