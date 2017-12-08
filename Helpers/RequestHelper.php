<?php

namespace doris\compressor\Helpers;

use Yii;

class RequestHelper
{
    public static function prepareData($request, $headers, $handler)
    {
        $tmp = explode(' ', $headers[0]);
        if (end($tmp) !== 'OK') {
            //TODO: realize logging here with getException $handler method
            return false;
        }

        return $handler->getData($request);
    }

}