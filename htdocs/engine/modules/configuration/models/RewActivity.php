<?php

namespace engine\modules\configuration\models;
use engine\modules\configuration\services\SettingService;

/**
 * This is the model class for table "rew_activity".
 */
class RewActivity extends RewActivityBase
{
    public function fields() {
        $fields = parent::fields();
        return $fields;
    }

}
