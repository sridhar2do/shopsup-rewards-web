<?php

namespace engine\modules\configuration\models;

use Yii;

/**
 * This is the model class for table "conf_option".
 *
 * @property integer $id
 * @property string $value
 * @property string $type
 *
 * @property AccUserProfile[] $accUserProfiles
 * @property ConfLocation[] $confLocations
 */
class ConfOptionBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'type'], 'required'],
            [['value'], 'string', 'max' => 256],
            [['type'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserProfiles()
    {
        return $this->hasMany(AccUserProfile::className(), ['gender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfLocations()
    {
        return $this->hasMany(ConfLocation::className(), ['parent_id' => 'id']);
    }
}
