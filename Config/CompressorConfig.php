<?php

namespace doris\compressor\Config;

use Exception;
use Yii;

/**
 * Class CompressorConfig
 *
 * @property string $imageDir
 * @property string $imageName
 * @property string $imageType
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

    public function initConfig()
    {
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