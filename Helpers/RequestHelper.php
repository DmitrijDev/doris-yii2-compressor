<?php

namespace doris\compressor\Helpers;

use doris\compressor\RequestHandlers\ImageHandler;
use Yii;

class RequestHelper
{
	/**
	 * @param string $request request from server (image)
	 * @param array $headers global array
	 * @param ImageHandler $handler
	 * @return mixed false or path to save
	 */
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