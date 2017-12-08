<?php

namespace doris\compressor\Helpers;

use Yii;

class PathHelper
{

    private $alias = '@webroot/';
    public $name; // file name
    public $dirPath; // path to directory with file
    public $filePathToGet; // full path with file to get
    public $filePathToSet; // full path with file to set
    public $returnPath; // path for site insert

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function setData($img, $path = false)
    {
        $tmp = explode('/', $img);
        $this->name = end($tmp);

        if ($path) {
            $this->dirPath = Yii::getAlias($this->alias . $path);
            $this->returnPath = $path . '/' . $this->name;

            if (!file_exists($this->dirPath)) {
                mkdir($this->dirPath, 0775, true);
            }
        } else {
            array_pop($tmp);
            $tmp = implode('/', $tmp);

            $this->dirPath = Yii::getAlias($this->alias . $tmp);
            $this->returnPath = $img;
        }

        $this->filePathToGet = Yii::getAlias('@webroot') . $img;
        $this->filePathToSet = $this->dirPath . '/' . $this->name;
    }
}