<?php

namespace engine\utils;

use Yii;

class TimeUtils {
    public static function getCurrentTimestampForStorage() {
        return Yii::$app->formatter->asDate ( time (), 'php:Y-m-d H:i:s' );
    }
}

?>