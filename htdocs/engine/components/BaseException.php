<?php

namespace engine\components;

use yii\base\Exception;

class BaseException extends Exception
{

    public function __construct($message, $code, Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }


}