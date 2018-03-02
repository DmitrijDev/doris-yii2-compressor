<?php
namespace doris\compressor\Services;

use Yii;
use Exception;

/**
 * Class RequestService
 */
class RequestService
{
    private $key;
    private $domain;

    const STATUS_OK = 'OK';

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
        $request = file_get_contents($this->domain . $method, false, $context);

        if (!$this->checkResponseStatus($http_response_header)) {
            throw new Exception($request);
        }

        return $request;
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

    protected function checkResponseStatus($http_response_header): bool
    {
        $status = explode(' ', $http_response_header[0]);

        return end($status) === self::STATUS_OK;
    }
}