<?php

namespace doris\compressor\RequestHandlers;

use Yii;

abstract class Handler
{
    abstract public function getException($data);

    abstract public function getData($data);
}