<?php
namespace doris\compressor\Adapters;

use doris\compressor\Config\CompressorConfig;

class RequestAdapter
{

    public static function getConfigForRequest(CompressorConfig $config): array
    {
        return [
            'file' => $config->imageContent,
            'key' => $config->key,
            'ext' => $config->imageType,
            'condition' => $config->conditionRatio
        ];
    }

}