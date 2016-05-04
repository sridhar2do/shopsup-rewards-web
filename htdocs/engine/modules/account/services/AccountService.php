<?php

namespace engine\modules\account\services;

use engine\modules\account\services\SessionService;
use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccUser;
use engine\modules\account\models\AccUserKey;
use engine\modules\account\models\AccUserOtp;
use engine\modules\notify\models\NotifySmsTemplates;
use engine\modules\notify\services\NotificationService;
use engine\modules\notify\services\SMSService;

class AccountService extends BaseService
{

    public function isEmailAvailable($email)
    {
        $user = AccUser::findOne(["email" => $email]);
        if (empty($user)) {
            return true;
        }


        return false;
    }

    public function isMobileAvailable($mobile)
    {
        $user = AccUser::findOne(["mobile" => $mobile]);
        if (empty($user)) {
            return true;
        }

        return false;
    }

    public function register($email = null, $mobile = null, $password, $autoLogin = true, $role = null)
    {

        if (!empty($email) && !empty($mobile)) {
            return $this->registerByEmailMobile($email, $mobile, $password, $autoLogin, $role);
        }

        if (!empty($email)) {
            return $this->registerByEmail($email, $password, $autoLogin, $role);
        }

        if (!empty($mobile)) {
            return $this->registerByMobile($mobile, $password, $autoLogin, $role);
        }

        throw new BaseException("Could not register the user.");

    }

    public function registerByEmailMobile($email, $mobile, $password, $autoLogin = true, $role = null)
    {
        $model = new AccUser();
        $model->email = $email;
        $model->mobile = $mobile;
        $model->setPassword($password);
        $model->is_verified = AccUser::VERIFICATION_DEFAULT;
        $model->is_active = AccUser::STATUS_DEFAULT;
        $model->save();
        if ($autoLogin && !$model->hasErrors()) {
            if (!empty($role)) {
                AccessService::model()->addRole($model, $role);
                OTPService::model()->sendRegistrationOTP($model);
            }
            $identity = SessionService::model()->login($email, null, $password);
            $model->authKey = $identity->authKey;
        }
        return $model;
    }

    public function registerByEmail($email, $password, $autoLogin = true, $role = null)
    {
        $model = new AccUser();
        $model->scenario = AccUser::SCENARIO_REGISTER_EMAIL;
        $model->email = $email;
        $model->setPassword($password);
        $model->is_verified = AccUser::VERIFICATION_DEFAULT;
        $model->is_active = AccUser::STATUS_DEFAULT;
        $model->save();
        if ($autoLogin && !$model->hasErrors()) {
            if (!empty($role)) {
                AccessService::model()->addRole($model, $role);
            }
            $identity = SessionService::model()->login($email, null, $password);
            $model->authKey = $identity->authKey;
        }
        return $model;
    }

    public function registerByMobile($mobile, $password, $autoLogin = true, $role = null)
    {
        $model = new AccUser();
        $model->scenario = AccUser::SCENARIO_REGISTER_MOBILE;
        $model->mobile = $mobile;
        $model->setPassword($password);
        $model->is_verified = AccUser::VERIFICATION_DEFAULT;
        $model->is_active = AccUser::STATUS_DEFAULT;
        $model->save();
        if ($autoLogin && !$model->hasErrors()) {
            if (!empty($role)) {
                AccessService::model()->addRole($model, $role);
                OTPService::model()->sendRegistrationOTP($model);
            }
            $identity = SessionService::model()->login(null, $mobile, $password);
            $model->authKey = $identity->authKey;
        }
        return $model;

    }

    public function getUser($user, $isActive = AccUser::STATUS_ACTIVE)
    {
        if ($user instanceof AccUser) {
            if ($user->is_active == $isActive) {
                return $user;
            }
            throw new BaseException("The user could not be found.");
        }

        if (is_numeric($user)) {
            try {
                return $this->getUserByPK($user, $isActive);
            } catch (BaseException $e) {
                return $this->getUserByMobile($user, $isActive);
            }
        }

        return $this->getUserByEmail($user, $isActive);

    }

    public function getUserByEmail($email, $isActive = AccUser::STATUS_ACTIVE)
    {
        $model = AccUser::findOne(["email" => $email, "is_active" => $isActive]);
        if (!empty($model)) {
            return $model;
        }

        throw new BaseException("User could not be found");
    }

    public function getUserByMobile($mobile, $isActive = AccUser::STATUS_ACTIVE)
    {
        $model = AccUser::findOne(["mobile" => $mobile, "is_active" => $isActive]);
        if (!empty($model)) {
            return $model;
        }

        throw new BaseException("User could not be found");
    }

    public function getUserByPK($id, $isActive = AccUser::STATUS_ACTIVE)
    {
        $model = AccUser::findOne(["id" => $id, "is_active" => $isActive]);
        if (!empty($model)) {
            return $model;
        }

        throw new BaseException("User could not be found");
    }

    public function updateMobile($user, $mobile)
    {
        $user = $this->getUser($user);
        if ($user->mobile == $mobile) {
            if (!$user->isMobileVerified()) {
                OTPService::model()->sendRegistrationOTP($user);
            }
            return true;
        }

        $user->mobile = $mobile;
        $status = $user->setMobileUnverified();
        if (!$status) {
            throw new BaseException("The mobile number could not be updated.");
        }

        $result = $user->save();
        if (!$result) {
            throw new BaseException("The mobile number could not be updated.");
        }
        OTPService::model()->sendRegistrationOTP($user);
        return true;
    }

    public function resendRegistrationOTP($user)
    {
        if (!$user->isMobileVerified()) {
            OTPService::model()->sendRegistrationOTP($user);
            return true;
        }

        throw new BaseException("This user's mobile is already verified.");

    }

    public function verifyMobile($user, $otp)
    {
        if ($user->isMobileVerified()) {
            return true;
        }

        try {
            $result = OTPService::model()->verifyOTP($user->mobile, $otp, OTPService::TYPE_REGISTER);
            if (!$result) {
                throw new BaseException("The OTP could not be verified.");
            }
        } catch (BaseException $e) {
            throw $e;
        }

        $user->setMobileVerified();

        if ($user->save()) {
            return true;
        }

        throw new BaseException("The mobile could not be verified.");

    }

    public function generateResetPasswordOTP($mobile)
    {
        $user = AccountService::model()->getUser($mobile);
        OTPService::model()->sendResetOTP($user);
        return true;
    }

    public function generatePasswordResetKeyByMobile($mobile, $otp)
    {
        $user = AccountService::model()->getUser($mobile);
        $result = OTPService::model()->verifyOTP($mobile, $otp, OTPService::TYPE_RESET);

        if($result) {
            $token = TokenService::model()->generateResetKey($user);
            if($token!=false) {
                return $token;
            }

            throw new BaseException("Could not generate the token");
        }

        throw new BaseException("Could not verify the OTP");
    }

    public function updatePasswordByToken($key, $password)
    {
        $user = TokenService::model()->getUser($key, TokenService::TYPE_RESET);
        return $this->updatePassword($user, $password);
    }

    public function updatePassword($user, $password)
    {
        $user = $this->getUser($user);
        $user->setPassword($password);
        $result = $user->save();
        if (!$result) {
            throw new BaseException("The password could not be updated");
        }
        return $result;
    }

}