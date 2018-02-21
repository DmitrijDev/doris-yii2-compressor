<?php

namespace doris\compressor\Config;

use Exception;
use Yii;

/**
 * Class CompressorConfig
 * @property string $image path to image with image name
 * @property int $condition condition of image compress (from 0 to 100)
 * @property boolean $generateName generate new image name if true
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
    private $image;
    private $condition = 85;
    private $generateName = false;

    private $imageDir;
    private $imageName;
    private $imageType;

    private $alias = '@webroot';
    private $returnPath;
    private $filePathToGet;
    private $filePathToSet;

    private $key;
    private $domain;

    private static $_instance = null;

    // TODO: write getters to all options
    public function __get($property)
    {
        switch ($property) {
            case 'name':
                return $this->name;
            case 'condition':
                return $this->condition;
            case 'alias':
                return $this->alias;
            default:
                throw new Exception("Property with name {$property} doesn't exist or can't be get");
        }
    }

    // TODO: write validation function for setters
    // TODO: write setters to all options
    public function __set($property, $value)
    {
        switch ($property) {
            case 'name':
                $this->name = $value;
                break;
            case 'condition':
                $this->condition = $value;
                break;
            case 'alias':
                $this->alias = $value;
                break;
            default:
                throw new Exception("Property with name {$property} doesn't exist or can't be set");
        }
    }

    // TODO: write code for generation path and image properties (use fabric method)
    public function initConfig(){

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