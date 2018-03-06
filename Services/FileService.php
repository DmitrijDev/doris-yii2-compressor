<?php
namespace doris\compressor\Services;

use Yii;
use Exception;

class FileService
{
    public $alias = '@webroot';
    public $pathToSave;
    public $customName;

    private $imagePath;
    private $imageDir;
    private $imageName;
    private $imageExt;

    private $maxImageSize = 3000000;

    public function saveImage(string $content): string
    {
        $imageName = $this->customName ? $this->customName . '.' . $this->imageExt : $this->imageName . '.' . $this->imageExt;

        if ($this->pathToSave) {
            $pathToSave = Yii::getAlias($this->alias) . '/' . $this->pathToSave;
            $returnPath = '/' . $this->pathToSave . '/' . $imageName;
        } else {
            $pathToSave = $this->imageDir;
            $returnPath = '/' . $this->imageDir . '/' . $imageName;
        }

        if (!file_exists($pathToSave)) {
            mkdir($pathToSave, 0777, true);
        }

        file_put_contents($pathToSave . '/' . $imageName, $content);

        return $returnPath;
    }

    public function getImageInfo(): array
    {
        $imagePath = Yii::getAlias($this->alias) . '/' . $this->imagePath;

        if (!file_exists($imagePath)) {
            throw new Exception("File {$imagePath} not exist");
        }

        if (filesize($imagePath) > $this->maxImageSize) {
            throw new Exception("File {$this->imagePath} is too big. Max file size is 3mb.");
        }

        $imageProperties = pathinfo($imagePath);
        $this->imageDir = $this->getValidPath($imageProperties['dirname']);
        $this->imageName = $imageProperties['filename'];
        $this->imageExt = $imageProperties['extension'];

        $imageContent = file_get_contents($imagePath);

        return [$this->imageExt, $imageContent];
    }

    public function setPathToImage(string $imagePath)
    {
        if (!$imagePath) {
            throw new Exception("Property pathToSave can't be empty");
        }

        $this->imagePath = $this->getValidPath($imagePath);
    }

    public function setPathToSave(string $pathToSave)
    {
        if (!$pathToSave) {
            throw new Exception("Property pathToSave can't be empty");
        }

        $this->pathToSave = $this->getValidPath($pathToSave);
    }

    public function setCustomName(string $customName)
    {
        if (!$customName) {
            throw new Exception("Property customName can't be empty");
        }

        $this->customName = trim($customName);
    }

    public function setAlias(string $alias)
    {
        if (!$alias) {
            throw new Exception("Property alias can't be empty");
        }

        $this->alias = trim($alias);
    }

    public function deleteOriginal(): bool
    {
        return unlink(Yii::getAlias($this->alias) . '/' . $this->imagePath);
    }

    private function getValidPath(string $path): string
    {
        return trim($path, '/');
    }
}