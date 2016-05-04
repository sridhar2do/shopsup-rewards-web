<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user_key".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property integer $is_active
 * @property string $type
 *
 * @property AccUser $user
 */
class AccUserKeyBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'is_active', 'type'], 'required'],
            [['user_id', 'is_active'], 'integer'],
            [['type'], 'string'],
            [['token'], 'string', 'max' => 256],
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
            'token' => 'Token',
            'is_active' => 'Is Active',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AccUser::className(), ['id' => 'user_id']);
    }
}
