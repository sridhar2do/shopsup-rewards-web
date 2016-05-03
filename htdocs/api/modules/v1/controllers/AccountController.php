<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace app\modules\v1\controllers;

use api\components\RestController;
use api\components\ResultObject;
use core\common\BaseException;
use core\modules\account\models\AccUser;
use core\modules\account\services\AccessService;
use core\modules\account\services\AccountService;
use core\modules\account\services\OTPService;
use core\modules\account\services\ProfileService;
use yii\web\HttpException;


/*
PUT account
DELETE session
*/

class AccountController extends RestController
{

    public function actionRegisterMember($email = null, $mobile = null, $password)
    {

        if (empty($mobile) && empty($email)) {
            throw new HttpException(400, "Either email or mobile is mandatory");
        }

        $model = AccountService::model()->register($email, $mobile, $password, true, AccessService::ROLE_MEMBER);

        if (!$model->hasErrors()) {
            return $model;
        }

        return $this->sendModelErrors($model);

    }

    public function actionRegisterSupplier($email = null, $mobile = null, $password)
    {

        if (empty($mobile) && empty($email)) {
            throw new HttpException(400, "Either email or mobile is mandatory");
        }

        $model = AccountService::model()->register($email, $mobile, $password, true, AccessService::ROLE_SUPPLIER);

        if (!$model->hasErrors()) {
            return $model;
        }

        return $this->sendModelErrors($model);

    }

    public function actionAvailabilityMobile($mobile)
    {
        $result = AccountService::model()->isMobileAvailable($mobile);
        if (!$result) {
            throw new HttpException(500, "The mobile number is not available");
        }

        return new ResultObject("The mobile number is available");
    }

    public function actionAvailabilityEmail($email)
    {
        $result = AccountService::model()->isEmailAvailable($email);
        if (!$result) {
            throw new HttpException(500, "The email is not available");
        }

        return new ResultObject("The email is available");
    }

    public function actionUpdateMobile($mobile)
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();

        try {
            $result = AccountService::model()->updateMobile($user, $mobile);
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        if (!$result) {
            throw new HttpException(500, "The mobile could not be updated.");
        }

        return $user;
    }

    public function actionMobileVerify($otp)
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();
        try {
            $result = AccountService::model()->verifyMobile($user, $otp);
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        if ($result) {
            return new ResultObject("The mobile was verified successfully");
        }

        throw new HttpException(500, "The mobile could not be verified");
    }

    public function actionResendVerificationOtp()
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();
        try {
            $result = AccountService::model()->resendRegistrationOTP($user);
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        return new ResultObject("The OTP was resent successfully");
    }

    public function actionGetBasicProfile()
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();
        try {
            $result = ProfileService::model()->getBasic($user);
        } catch (BaseException $e) {
            throw new BaseException(500, $e->getMessage());
        }

        return $result;
    }

    public function actionUpdateBasicProfile($first_name = false, $last_name = false, $gender = false, $date_of_birth = false)
    {
        $this->requireAuthentication();
        $user = $this->getLoggedInUser();
        try {
            $data = [];
            if ($first_name && !empty($first_name)) {
                $data["first_name"] = $first_name;
            }
            if ($last_name && !empty($last_name)) {
                $data["last_name"] = $last_name;
            }
            if ($gender && !empty($gender)) {
                $data["gender"] = $gender;
            }
            if ($date_of_birth && !empty($date_of_birth)) {
                $data["date_of_birth"] = $date_of_birth;
            }
            $profile = ProfileService::model()->updateBasic($user, $data);
            if ($profile->hasErrors()) {
                $this->sendModelErrors($profile);
            }
            return $profile;
        } catch (BaseException $e) {
            throw new BaseException(500, $e->getMessage());
        }

    }

    public function actionInitiateResetPassword($mobile)
    {
        $this->requireGuest();
        try {
            $result = AccountService::model()->generateResetPasswordOTP($mobile);
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        if ($result) {
            return new ResultObject(200, "The operation was completed successfully");
        }

        throw new HttpException(500, "An unknown error occurred.");
    }

    public function actionGetPasswordResetKey($mobile, $otp)
    {
        $this->requireGuest();
        try {
            $result = AccountService::model()->generatePasswordResetKeyByMobile($mobile, $otp);
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        if ($result!=false) {
            return ["token"=>$result];
        }

        throw new HttpException(500, "An unknown error occurred.");

    }

    public function actionUpdatePasswordResetKey($token, $password)
    {
        $this->requireGuest();
        try {
            $result = AccountService::model()->updatePasswordByToken($token, $password);
        } catch (BaseException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        if ($result) {
            return new ResultObject(200, "The operation was completed successfully");
        }

        throw new HttpException(500, "An unknown error occurred.");

    }

}