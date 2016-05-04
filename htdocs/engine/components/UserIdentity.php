<?php

namespace engine\components;

use engine\modules\account\models\AccUser;
use engine\modules\account\models\AccUserSession;
use engine\modules\account\models\AccUserBase;
use Yii;
use yii\web\IdentityInterface;

class UserIdentity extends AccUser implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne ( [
            'id' => $id,
            'is_active' => self::STATUS_ACTIVE
        ] );
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $model = AccUserSession::findOne ( [
            'auth_key' => $token,
            'is_active' => AccUserSession::STATUS_ACTIVE
        ] );

        if(empty($model)) {
            return null;
        }

        return $model->identityUser;
    }
}
