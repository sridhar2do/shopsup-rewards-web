<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user_otp".
 *
 * @property integer $id
 * @property integer $mobile
 * @property string $otp
 * @property string $type
 * @property integer $is_active
 */
class AccUserOtpBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_otp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'otp'], 'required'],
            [['mobile', 'is_active'], 'integer'],
            [['type'], 'string'],
            [['otp'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'otp' => 'Otp',
            'type' => 'Type',
            'is_active' => 'Is Active',
        ];
    }
}
