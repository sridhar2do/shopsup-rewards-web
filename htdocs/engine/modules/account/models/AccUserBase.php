<?php

namespace engine\modules\account\models;

use Yii;

/**
 * This is the model class for table "acc_user".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $mobile
 * @property string $is_verified
 * @property integer $is_active
 *
 * @property AccUserKey[] $accUserKeys
 * @property AccUserProfile[] $accUserProfiles
 * @property AccUserRole[] $accUserRoles
 * @property AccRole[] $roles
 * @property AccUserSession[] $accUserSessions
 */
class AccUserBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'is_active'], 'required'],
            [['mobile', 'is_active'], 'integer'],
            [['email', 'password'], 'string', 'max' => 256],
            [['is_verified'], 'string', 'max' => 4],
            [['email'], 'unique'],
            [['mobile'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'is_verified' => 'Is Verified',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserKeys()
    {
        return $this->hasMany(AccUserKey::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserProfiles()
    {
        return $this->hasMany(AccUserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserRoles()
    {
        return $this->hasMany(AccUserRole::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(AccRole::className(), ['id' => 'role_id'])->viaTable('acc_user_role', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserSessions()
    {
        return $this->hasMany(AccUserSession::className(), ['user_id' => 'id']);
    }
}
