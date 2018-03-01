<?php
namespace doris\compressor\services;

use Yii;

/**
 * Class RequestService
 */
class RequestService
{
    public $conditionRatio = 85;

    private $key;
    private $domain;

    private $request;
    private $http_response_header;

    const STATUS_OK = 'OK';

    public function __construct()
    {
        $configs = Yii::$app->params['ImageCompressor'];

        $this->key = $configs['key'];
        $this->domain = $configs['domain'];
    }

    public function sendRequest(string $imageExt, string $imageContent): bool
    {
        $method = '/image';
        $requestData = $this->prepareDataForRequest($imageExt, $imageContent);

        $options = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($requestData),
                'ignore_errors' => true,
                'header' => "Content-Type: application/x-www-form-urlencoded"
            ]
        ];

        $context = stream_context_create($options);
        $request = file_get_contents($this->domain . $method, false, $context);

        $this->request = $request;
        $this->http_response_header = $http_response_header;

        return $this->checkResponseStatus();
    }

    protected function prepareDataForRequest(string $imageExt, string $imageContent): array
    {
        return [
            'file' => $imageContent,
            'key' => $this->key,
            'ext' => $imageExt,
            'condition' => $this->conditionRatio
        ];
    }

    protected function checkResponseStatus(): bool
    {
        $status = explode(' ', $this->http_response_header[0]);

        return end($status) === self::STATUS_OK;
    }

    public function getResponse(): string
    {
        return $this->request;
    }
}