<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user_device".
 *
 * @property integer $id
 * @property integer $session_id
 * @property integer $device_id
 *
 * @property AccUserSession $session
 * @property AccUserDeviceBase $device
 * @property AccUserDeviceBase[] $accUserDeviceBases
 * @property AccUserDeviceInfo[] $accUserDeviceInfos
 */
class AccUserDeviceBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_id', 'device_id'], 'required'],
            [['session_id', 'device_id'], 'integer'],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccUserSession::className(), 'targetAttribute' => ['session_id' => 'id']],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccUserDeviceBase::className(), 'targetAttribute' => ['device_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'device_id' => 'Device ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(AccUserSession::className(), ['id' => 'session_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(AccUserDeviceBase::className(), ['id' => 'device_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserDeviceBases()
    {
        return $this->hasMany(AccUserDeviceBase::className(), ['device_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserDeviceInfos()
    {
        return $this->hasMany(AccUserDeviceInfo::className(), ['device_id' => 'id']);
    }
}
