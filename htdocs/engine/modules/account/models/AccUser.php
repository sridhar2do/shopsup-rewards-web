<?php

namespace engine\modules\account\models;

use engine\modules\account\models\AccUserBase;
use Yii;

class AccUser extends AccUserBase
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DEFAULT = 1;
    const VERIFICATION_DEFAULT = "00";

    const SCENARIO_REGISTER_MOBILE = "REGISTER_MOBILE";
    const SCENARIO_REGISTER_EMAIL = "REGISTER_EMAIL";

    public $authKey;

    public function setAuthKey($key) {
        $this->authKey = $key;
    }

    public function fields() {
        $fields = [];
        $fields["email"] = "email";
        $fields["mobile"] = "mobile";
        // $fields = ["is_active"] = "isActive";
        $fields["is_mobile_verified"] = "mobileVerificationStatus";
        $fields["is_email_verified"] = "emailVerificationStatus";

        $fields["auth_key"] = "authKey";


        return $fields;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER_EMAIL] = ['email', 'password'];
        $scenarios[self::SCENARIO_REGISTER_MOBILE] = ['mobile', 'password'];
        return $scenarios;
    }

    public function getMobileVerificationStatus() {
        return $this->isMobileVerified();
    }

    public function getEmailVerificationStatus() {
        return $this->isEmailVerified();
    }

    public function isMobileVerified()
    {
        $status = $this->is_verified;
        if (count($status) < 1) {
            return false;
        }

        $digit = substr($status, 0, 1);
        if ($digit == 1) {
            return true;
        }

        return false;
    }

    public function isEmailVerified()
    {
        $status = $this->is_verified;
        if (count($status) < 2) {
            return false;
        }

        $digit = substr($status, 1, 1);
        if ($digit == 1) {
            return true;
        }

        return false;
    }

    public function setMobileVerified() {
        $status = $this->is_verified;
        if (count($status) < 1) {
            return false;
        }
        $this->is_verified = substr_replace($status,1,0,1);
        return true;
    }

    public function setMobileUnverified() {
        $status = $this->is_verified;
        if (count($status) < 1) {
            return false;
        }
        $this->is_verified = substr_replace($status,0,0,1);
        return true;
    }

    public function setEmailVerified() {
        $status = $this->is_verified;
        if (count($status) < 2) {
            return false;
        }
        $this->is_verified = substr_replace($status,1,1,1);
        return true;
    }

    public function setEmailUnverified() {
        $status = $this->is_verified;
        if (count($status) < 2) {
            return false;
        }
        $this->is_verified = substr_replace($status,0,1,1);
        return true;
    }


    public function isVerified()
    {
        return $this->isMobileVerified() && $this->isEmailVerified();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey ();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey () === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password
     *        	password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword ( $password, $this->password );
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash ( $password );
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        return Yii::$app->security->generateRandomString ();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->reset_key = Yii::$app->security->generateRandomString () . '_' . time ();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetOTP() {
        $this->reset_otp = rand ( 10000, 99999 ) . "";
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->reset_key = "";
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetOTP() {
        $this->reset_otp = "";
    }

    public function getContactName() {
        return $this->email;
    }

    public function getContactMobile() {
        return $this->mobile;
    }

    public function getContactEmail() {
        return $this->email;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }

    public function getAccUserProfile()
    {
        return $this->hasOne(AccUserProfile::className(), ['user_id' => 'id']);
    }

}