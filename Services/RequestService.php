<?php

namespace doris\compressor\Services;

use Yii;

use doris\compressor\Helpers\RequestHelper;
use doris\compressor\RequestHandlers\ImageHandler;

class RequestService
{
    public function getCompressed($data)
    {
        $domain = Yii::$app->params['ImageCompressor']['domain'];
        $method = '/image';

        if (empty($domain)) {
            throw new \Exception('Can\'t download site domain.');
        }

        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data),
                'ignore_errors' => true,
                'header' => "Content-Type: application/x-www-form-urlencoded"
            )
        );

        $context = stream_context_create($options);
        $request = file_get_contents($domain . $method, false, $context);

        $handler = new ImageHandler();

        return RequestHelper::prepareData($request, $http_response_header, $handler);
    }

}