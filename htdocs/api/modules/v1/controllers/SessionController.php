<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace app\modules\v1\controllers;

use api\components\RestController;
use api\components\ResultObject;
use engine\components\BaseException;
use engine\modules\account\services\SessionService;
use yii\web\HttpException;


class SessionController extends RestController
{

    public function actionLogin($mobile = null, $email = null, $password)
    {
        $this->requireGuest();
        if (empty($mobile) && empty($email)) {
            throw new HttpException(400, "Either email or mobile is mandatory");
        }

        try {
            $user = SessionService::model()->login($email, $mobile, $password);
            $this->authKey = $user->getAuthKey();
            return $user;
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        throw new HttpException(500, "The user could not be logged in");
    }

    public function actionLogout()
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();
        try {
            $key = $this->getAuthKey();
            $result = SessionService::model()->logout($user, $key);
            if ($result) {
                return new ResultObject("The user was successfully logged out");
            }
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        throw new HttpException(500, "The user could not be logged out");
    }

    public function actionMe()
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();

        return $user;
    }

}