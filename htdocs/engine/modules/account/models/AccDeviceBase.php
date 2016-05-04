<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_device".
 *
 * @property integer $id
 * @property string $registration_token
 * @property integer $is_active
 * @property string $last_active
 */
class AccDeviceBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_token'], 'required'],
            [['is_active'], 'integer'],
            [['last_active'], 'safe'],
            [['registration_token'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration_token' => 'Registration Token',
            'is_active' => 'Is Active',
            'last_active' => 'Last Active',
        ];
    }
}
