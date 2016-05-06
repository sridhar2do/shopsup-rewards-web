<?php

namespace engine\modules\configuration\models;

use Yii;

/**
 * This is the model class for table "conf_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $icon
 *
 * @property ConfSubcategory[] $confSubcategories
 * @property ConfSubcategory[] $confSubcategories0
 */
class ConfCategoryBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['icon'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'icon' => 'Icon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfSubcategories()
    {
        return $this->hasMany(ConfSubcategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfSubcategories0()
    {
        return $this->hasMany(ConfSubcategory::className(), ['sub_category_id' => 'id']);
    }
}
