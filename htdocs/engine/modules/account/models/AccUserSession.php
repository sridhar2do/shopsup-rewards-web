<?php

namespace engine\modules\account\models;

use engine\components\UserIdentity;


class AccUserSession extends AccUserSessionBase
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function getIdentityUser()
    {
        return $this->hasOne(UserIdentity::className(), ['id' => 'user_id']);
    }

}