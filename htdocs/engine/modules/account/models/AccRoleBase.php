<?php

namespace engine\modules\account\models;

use engine\modules\account\models\AccUser;
use Yii;

/**
 * This is the model class for table "acc_role".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_active
 *
 * @property AccUserRole[] $accUserRoles
 * @property AccUser[] $users
 */
class AccRoleBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_active'], 'integer'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserRoles()
    {
        return $this->hasMany(AccUserRole::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(AccUser::className(), ['id' => 'user_id'])->viaTable('acc_user_role', ['role_id' => 'id']);
    }
}
