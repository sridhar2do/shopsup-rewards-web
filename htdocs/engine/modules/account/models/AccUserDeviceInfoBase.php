<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user_device_info".
 *
 * @property integer $device_id
 * @property string $label
 * @property string $value
 *
 * @property AccUserDevice $device
 */
class AccUserDeviceInfoBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_device_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'label', 'value'], 'required'],
            [['device_id'], 'integer'],
            [['label', 'value'], 'string', 'max' => 100],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccUserDevice::className(), 'targetAttribute' => ['device_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'Device ID',
            'label' => 'Label',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(AccUserDevice::className(), ['id' => 'device_id']);
    }
}
