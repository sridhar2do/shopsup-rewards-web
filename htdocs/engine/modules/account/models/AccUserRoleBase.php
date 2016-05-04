<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user_role".
 *
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $is_active
 *
 * @property AccUser $user
 * @property AccRole $role
 */
class AccUserRoleBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'is_active'], 'required'],
            [['user_id', 'role_id', 'is_active'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccRole::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AccUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AccRole::className(), ['id' => 'role_id']);
    }
}
