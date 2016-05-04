<?php

namespace engine\modules\account\models;

use engine\modules\configuration\models\ConfLocation;
use engine\modules\configuration\models\ConfOption;
use Yii;

/**
 * This is the model class for table "acc_user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property integer $gender_id
 * @property integer $city_id
 *
 * @property AccUser $user
 * @property ConfOption $gender
 * @property ConfLocation $city
 */
class AccUserProfileBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acc_user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender_id', 'city_id'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfOption::className(), 'targetAttribute' => ['gender_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfLocation::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
            'gender_id' => 'Gender ID',
            'city_id' => 'City ID',
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
    public function getGender()
    {
        return $this->hasOne(ConfOption::className(), ['id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(ConfLocation::className(), ['id' => 'city_id']);
    }
}
