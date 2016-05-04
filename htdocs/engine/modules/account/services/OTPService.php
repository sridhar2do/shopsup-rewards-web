<?php

namespace engine\modules\account\services;

use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccUserOtp;
use engine\modules\notify\services\NotificationService;

class OTPService extends BaseService
{

    const TYPE_REGISTER = "REGISTER";
    const TYPE_RESET = "RESET";


    public function getActiveOTP($mobile, $type = self::TYPE_REGISTER)
    {
        $result = AccUserOtp::findOne(["mobile" => $mobile, "is_active" => AccUserOtp::STATUS_ACTIVE, "type" => $type]);
        if (!$result) {
            throw new BaseException("An active OTP was not found for the mobile.");
        }
        return $result;
    }

    public function generateOTP($mobile, $type = self::TYPE_REGISTER)
    {
        $otp = mt_rand(100000, 999999);
        $model = new AccUserOtp();
        $model->mobile = $mobile;
        $model->otp = "$otp";
        $model->type = $type;
        $model->is_active = AccUserOtp::STATUS_ACTIVE;
        $result = $model->save();
        if (!$result) {
            throw new BaseException("An OTP could not be generated for the mobile.");
        }
        return $model;
    }

    public function sendRegistrationOTP($user)
    {
        $user = AccountService::model()->getUser($user);
        if (!empty($user->mobile)) {
            if (!$user->isMobileVerified()) {
                // $requireVerification = SettingService::model()->getSettingForWeb(Setting::ACCOUNT_VERIFY_MOBILE);
                $requireVerification = true;
                if ($requireVerification == true) {
                    try {
                        $otpModel = $this->getActiveOTP($user->mobile, self::TYPE_REGISTER);
                    } catch (BaseException $e) {
                        $otpModel = $this->generateOTP($user->mobile, self::TYPE_REGISTER);
                    }
                    if (empty($otpModel)) {
                        throw new BaseException("An OTP could not be generated for the mobile.");
                    }
                    $otp = $otpModel->otp;
                    $data = [];
                    $data["{code}"] = $otp;

                    if (empty($otp)) {
                        return false;
                    }
                    NotificationService::model()->sendSMS($user->mobile, "091", NotificationService::SCENARIO_MOBILE_VERIFICATION, $data);
                    return true;
                }
            }
        }

        return false;
    }

    public function sendResetOTP($user)
    {
        $user = AccountService::model()->getUser($user);

        try {
            $otpModel = $this->getActiveOTP($user->mobile, self::TYPE_RESET);
        } catch (BaseException $e) {
            $otpModel = $this->generateOTP($user->mobile, self::TYPE_RESET);
        }
        if (empty($otpModel)) {
            throw new BaseException("An OTP could not be generated for the mobile.");
        }
        $otp = $otpModel->otp;
        $data = [];
        $data["{code}"] = $otp;

        if (empty($otp)) {
            return false;
        }

        NotificationService::model()->sendSMS($user->mobile, "091", NotificationService::SCENARIO_USER_PASSWORD_RESET, $data);
        return true;
    }

    public function verifyOTP($mobile, $otp, $type = self::TYPE_REGISTER)
    {
        $otpModel = $this->getActiveOTP($mobile, $type);
        if ($otp != $otpModel->otp) {
            throw new BaseException("Invalid OTP");
        }

        $otpModel->is_active = AccUserOtp::STATUS_INACTIVE;
        return $otpModel->save();
    }


}