<?php
/**
 * Created by PhpStorm.
 * User: karthickl
 * Date: 23/03/16
 * Time: 9:17 PM
 */

namespace engine\modules\account\services;

use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccUserKey;

class TokenService extends BaseService
{

    const TYPE_RESET = "RESET";

    public function getUser($key, $type, $status = AccUserKey::STATUS_ACTIVE)
    {
        $model = AccUserKey::findOne(["token" => $key, "type" => $type, "is_active" => $status]);
        if (!empty($model)) {
            return $model->user;
        }

        throw new BaseException("User could not be found");
    }

    public function generateResetKey($user)
    {
        $user = AccountService::model()->getUser($user);
        $key = new AccUserKey();
        $key->user_id = $user->id;
        $key->token = \Yii::$app->security->generateRandomString();
        $key->is_active = AccUserKey::STATUS_ACTIVE;
        $key->type = self::TYPE_RESET;
        $result = $key->save();
        if($result) {
            return $key->token;
        }

        throw new BaseException("The key could not be generated.");
    }

}