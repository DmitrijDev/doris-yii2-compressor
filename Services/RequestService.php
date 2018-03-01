<?php

namespace doris\compressor\Services;

use doris\compressor\Adapters\RequestAdapter;
use doris\compressor\Helpers\RequestHelper;
use doris\compressor\Config\CompressorConfig;
use doris\compressor\RequestHandlers\ImageHandler;

class RequestService
{

    public function getCompressed(CompressorConfig $config)
    {
        $method = '/image';

        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query(RequestAdapter::getConfigForRequest($config)),
                'ignore_errors' => true,
                'header' => "Content-Type: application/x-www-form-urlencoded"
            )
        );

        $context = stream_context_create($options);
        $request = file_get_contents($config->domain . $method, false, $context);


        return RequestHelper::prepareData($request, $http_response_header);
    }

}