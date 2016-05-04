<?php

namespace engine\modules\account\services;

use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccUser;
use engine\modules\account\models\AccUserSession;
use engine\modules\account\services\AccountService;
use yii\web\User;

class SessionService extends BaseService {


    public function login($email=null, $mobile=null, $password, $isActive = AccUser::STATUS_ACTIVE) {

        if(!empty($email)) {
            $model = AccUser::findOne(["email"=>$email,"is_active"=>$isActive]);
        }elseif(!empty($mobile)) {
            $model = AccUser::findOne(["mobile"=>$mobile,"is_active"=>$isActive]);
        }

        if(empty($model)) {
            throw new BaseException("The user could not be found");
        }

        $valid = $model->validatePassword($password);
        if(!$valid) {
            throw new BaseException("The user can not login");
        }

        $session = new AccUserSession();
        $session->user_id = $model->id;
        $session->auth_key = $model->generateAuthKey();
        $session->is_active = AccUserSession::STATUS_ACTIVE;
        $result = $session->save();

        if(!$result) {
            throw new BaseException("The user could not be logged in");
        }

        $user = $session->identityUser;
        $user->setAuthKey($session->auth_key);

        return $user;
    }

    public function logout($user, $authKey) {
        $user = AccountService::model()->getUser($user);
        $model = AccUserSession::findOne(["user_id"=>$user->id, "auth_key"=>$authKey]);
        $model->is_active = AccUserSession::STATUS_INACTIVE;
        $result = $model->save();
        if($result) {
           return true;
        }

        throw new BaseException("The user could not be logged out");
    }

    public function getSessionByKey($auth) {
        $session = AccUserSession::findOne(["auth_key"=>$auth, "is_active"=>AccUserSession::STATUS_ACTIVE]);
        if(!$session) {
            throw new BaseException("Session could not be found.");
        }
        return $session;
    }
}