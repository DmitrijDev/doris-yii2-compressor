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
        $target_url = $this->domain . '/image';

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $target_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->prepareDataForRequest($imageExt, $imageContent, $compressRatio)
        ));
        $request = curl_exec($ch);

        if (curl_errno($ch)) {
            $message = curl_error($ch);
            curl_close($ch);

            throw new Exception($message);
        }

        curl_close($ch);
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