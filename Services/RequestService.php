<?php
namespace doris\compressor\services;

use Yii;

/**
 * Class RequestService
 */
class RequestService
{
    private $key;
    private $domain;

    public function __construct()
    {
        $configs = Yii::$app->params['ImageCompressor'];

        $this->key = $configs['key'];
        $this->domain = $configs['domain'];
    }

    public function sendRequest(string $imageExt, string $imageContent, int $compressRatio): string
    {
        $method = '/image';
        $requestData = $this->prepareDataForRequest($imageExt, $imageContent, $compressRatio);

        $options = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($requestData),
                'ignore_errors' => true,
                'header' => "Content-Type: application/x-www-form-urlencoded"
            ]
        ];

        $context = stream_context_create($options);
        return file_get_contents($this->domain . $method, false, $context);
    }

    protected function prepareDataForRequest(string $imageExt, string $imageContent, int $compressRatio): array
    {
        return [
            'file' => $imageContent,
            'key' => $this->key,
            'ext' => $imageExt,
            'condition' => $compressRatio
        ];
    }
}