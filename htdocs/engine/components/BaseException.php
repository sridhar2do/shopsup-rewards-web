<?php

namespace engine\components;

use yii\base\Exception;

class BaseException extends Exception
{

    public function __construct($message, $code=500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}