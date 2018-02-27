<?php

namespace doris\compressor\Config;

use Exception;
use Yii;

/**
 * Class CompressorConfig
 * @property string $image path to image with image name
 * @property int $condition condition of image compress (from 0 to 100)
 * @property boolean $generateName generate new image name if true
 * @property string $pathToSave path to dir where need to save image
 * @property boolean $deleteOriginal delete original image after successful compressing
 *
 * @property string $imageDir
 * @property string $imageName
 * @property string $imageType
 *
 * @property string $filePathToGet
 * @property string $filePathToSet
 * @property string $returnPath
 * @property string $alias
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
    private $image;
    private $condition = 85;
    private $generateName = false;
    private $pathToSave;
    private $deleteOriginal = false;
    private $alias = '@webroot';

    /**
     * It's generated options
     */
    private $imageDir;
    private $imageName;
    private $imageType;
    private $returnPath;
    private $filePathToGet;
    private $filePathToSet;

    /**
     * This options should be in config file
     */
    private $key;
    private $domain;

    private static $_instance = null;

    // TODO: maybe initConfig may be called here
    public function __get($property)
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
            default:
                throw new Exception("Property with name {$property} doesn't exist or can't be get");
        }
    }

    public function __set($property, $value)
    {
        switch ($property) {
            case 'image':
                $this->image = $value;
                break;
            case 'condition':
                $this->condition = $value;
                break;
            case 'alias':
                $this->alias = $value;
                break;
            case 'generateName':
                $this->generateName = $value;
                break;
            case 'pathToSave':
                $this->pathToSave = $value;
                break;
            case 'deleteOriginal':
                $this->deleteOriginal = $value;
                break;
            default:
                throw new Exception("Property with name {$property} doesn't exist or can't be set");
        }
    }

    public function initConfig()
    {
        if (!$this->validate()) {
            return;
        }

        if($this->pathToSave){
            $this->generateNewPathConfig();
        } else{
            $this->generateOldPathConfig();
        }
    }

    // TODO: write validation code here
    public function validate()
    {
        return true;
    }

    private function __construct()
    {
        try {
            $configs = Yii::$app->params['ImageCompressor'];

            $this->key = $configs['key'];
            $this->domain = $configs['domain'];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function generateNewPathConfig()
    {

    }

    private function generateOldPathConfig()
    {

    }

    protected function __clone()
    {
    }

    static public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}