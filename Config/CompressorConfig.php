<?php

namespace doris\compressor\Config;

use Exception;
use Yii;

/**
 * Class CompressorConfig
 * @property string $imagePath path to image with image name
 * @property int $conditionRatio condition of image compress (from 0 to 100)
 * @property string $customName set custom name after save
 * @property string $pathToSave path to dir where need to save image
 * @property boolean $deleteOriginal delete original image after successful compressing
 * @property string $alias
 *
 * @property string $imageDir
 * @property string $imageName
 * @property string $imageType
 * @property string $imageContent
 *
 * @property string $filePathToGet
 * @property string $filePathToSet
 * @property string $returnPath
 *
 * @property string $key
 * @property string $domain
 *
 */
class CompressorConfig
{
    /**
     * User can set this options
     */
    public $alias = '@webroot';
    public $conditionRatio = 85;
    public $imagePath;
    public $pathToSave;
    public $customName;
    public $deleteOriginal = false;

    /**
     * It's generated options
     */
    private $imageDir;
    private $imageName;
    private $imageType;
    private $returnPath;
    private $imageContent;
    private $filePathToGet;
    private $filePathToSet;

    /**
     * This options should be in config file
     */
    private $key;
    private $domain;

    public function __get(string $property)
    {
        switch ($property) {
            case 'imageDir':
                return $this->imageDir;
            case 'imageName':
                return $this->imageName;
            case 'imageType':
                return $this->imageType;
            case 'returnPath':
                return $this->returnPath;
            case 'filePathToGet':
                return $this->filePathToGet;
            case 'filePathToSet':
                return $this->filePathToSet;
            case 'imageContent':
                return $this->imageContent;
            case 'key' :
                return $this->key;
            case 'domain' :
                return $this->domain;
            default:
                throw new Exception("Property with name {$property} doesn't exist or can't be getted");
        }
    }

    public function getConfigForRequest(): array
    {
        return [
            'file' => $this->imageContent,
            'key' => $this->key,
            'ext' => $this->imageType,
            'condition' => $this->conditionRatio
        ];
    }

    public function initConfig()
    {
        $this->validate();

        $imageProperties = pathinfo($this->imagePath);

        $this->imageDir = str_replace('/', '\\', $imageProperties['dirname']);
        $this->imageName = $imageProperties['filename'];
        $this->imageType = $imageProperties['extension'];

        if (empty($this->pathToSave)) {
            $this->generatePathToOverwrite();
        } else {
            $this->generatePathToSave();
        }

        $this->imageContent = file_get_contents($this->filePathToGet);
    }

    private function validate(): bool
    {
        // TODO:: need validate data here. Generate exception if find invalid property
        return true;
    }

    public function __construct()
    {
        try {
            $configs = Yii::$app->params['ImageCompressor'];

            $this->key = $configs['key'];
            $this->domain = $configs['domain'];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function generatePathToSave()
    {
        $imageName = $this->customName ? $this->customName : $this->imageName;

        $this->pathToSave = str_replace('/', '\\', $this->pathToSave);
        $this->filePathToGet = Yii::getAlias($this->alias) . '\\' . $this->imageDir . '\\' . $this->imageName . '.' . $this->imageType;
        $this->filePathToSet = Yii::getAlias($this->alias) . '\\' . $this->pathToSave . '\\' . $imageName . '.' . $this->imageType;
        $this->returnPath = $this->pathToSave . '\\' . $imageName . '.' . $this->imageType;
    }

    private function generatePathToOverwrite()
    {
        $this->filePathToGet = Yii::getAlias($this->alias) . '\\' . $this->imageDir . '\\' . $this->imageName . '.' . $this->imageType;
        $this->filePathToSet = Yii::getAlias($this->alias) . '\\' . $this->imageDir . '\\' . $this->imageName . '.' . $this->imageType;
        $this->returnPath = $this->imageDir . '\\' . $this->imageName . '.' . $this->imageType;
    }
}