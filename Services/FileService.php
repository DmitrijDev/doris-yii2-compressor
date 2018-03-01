<?php
namespace doris\compressor\services;

use Yii;

class FileService
{
    public $alias = '@webroot';
    public $imagePath;
    public $pathToSave;
    public $customName;
    public $deleteOriginal = false;

    private $compressedImagePath;

    public function saveImage(string $content): bool
    {
        $imageInfo = pathinfo($this->imagePath);

        $imageDir = $imageInfo['dirname'];

        if ($this->customName) {
            $imageExt = $imageInfo['extension'];
            $imageName = $this->customName . '.' . $imageExt;
        } else {
            $imageName = $imageInfo['basename'];
        }

        if ($this->pathToSave) {
            $pathToSave = Yii::getAlias($this->alias) . '\\' . $this->pathToSave;
        } else {
            $pathToSave = Yii::getAlias($this->alias) . '\\' . $imageDir;
        }

        if (!file_exists($pathToSave)) {
            mkdir($pathToSave, 0777, true);
        }

        $this->compressedImagePath = $this->pathToSave . '\\' . $imageName;

        file_put_contents($pathToSave . '\\' . $imageName, $content);


        if ($this->deleteOriginal) {
            unlink($this->alias . '\\' . $this->imagePath);
        }

        return true;
    }

    public function getImageExt(): string
    {
        return pathinfo(Yii::getAlias($this->alias) . '\\' . $this->imagePath)['extension'];
    }

    public function getImageName(): string
    {
        return pathinfo(Yii::getAlias($this->alias) . '\\' . $this->imagePath)['basename'];
    }

    public function getImageContent(): string
    {
        return file_get_contents(Yii::getAlias($this->alias) . '\\' . $this->imagePath);
    }

    public function getCompressedImagePath(): string
    {
        return str_replace('\\', '/', $this->compressedImagePath);
    }
}