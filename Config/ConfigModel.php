<?php

namespace doris\compressor\Config;

use Yii;

/**
 * Class ConfigModel
 * @property string $image path to image with image name
 * @property int $condition condition of image compress (from 0 to 100)
 * @property boolean $generateName generate new image name if true
 * @property string $pathToSave path to dir where need to save image
 * @property boolean $deleteOriginal delete original image after successful compressing]
 * @property string $alias
 */
class ConfigModel
{
    public $image;
    public $condition = 85;
    public $generateName = false;
    public $pathToSave;
    public $deleteOriginal = false;
    public $alias = '@webroot';

    public function validate()
    {

    }
}