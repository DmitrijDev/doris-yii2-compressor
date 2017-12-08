<?php

namespace doris\compressor\RequestHandlers;

use Yii;

class ImageHandler extends Handler
{
    public function getException($data)
    {
        if((string) $data){
            return $data;
        }

        return 'Data is empty. Check log on server.';
    }

    public function getData($data)
    {
        if((string) $data){
            return $data;
        }

        return false;
    }
}