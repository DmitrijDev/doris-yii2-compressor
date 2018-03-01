<?php

namespace doris\compressor\Helpers;

use doris\compressor\RequestHandlers\ImageHandler;
use Yii;

class RequestHelper
{
    const STATUS_OK = 'OK';

    /**
     * @param string $request request from server (image)
     * @param array $headers global array
     * @return mixed false or path to save
     */
    public static function prepareData($request, $headers)
    {
        $tmp = explode(' ', $headers[0]);
        if (end($tmp) !== self::STATUS_OK) {
            //TODO: realize logging here with getException $handler method
            return false;
        }

        return $request;
    }

}