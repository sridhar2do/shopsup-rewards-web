<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user_session".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $auth_key
 * @property integer $is_active
 *
 * @property AccUserDevice[] $accUserDevices
 * @property AccUser $user
 */
class AccUserSessionBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'auth_key'], 'required'],
            [['user_id', 'is_active'], 'integer'],
            [['auth_key'], 'string', 'max' => 256],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'auth_key' => 'Auth Key',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserDevices()
    {
        return $this->hasMany(AccUserDevice::className(), ['session_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AccUser::className(), ['id' => 'user_id']);
    }
}
