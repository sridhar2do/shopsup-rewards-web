<?php

namespace engine\modules\configuration\models;

use Yii;

/**
 * This is the model class for table "conf_location".
 *
 * @property integer $id
 * @property string $value
 * @property string $type
 * @property integer $parent_id
 *
 * @property AccUserProfile[] $accUserProfiles
 * @property ConfOption $parent
 */
class ConfLocationBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'type'], 'required'],
            [['type'], 'string'],
            [['parent_id'], 'integer'],
            [['value'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfOption::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccUserProfiles()
    {
        return $this->hasMany(AccUserProfile::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ConfOption::className(), ['id' => 'parent_id']);
    }
}
