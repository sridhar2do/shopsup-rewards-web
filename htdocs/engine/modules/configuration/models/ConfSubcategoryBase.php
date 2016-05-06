<?php

namespace engine\modules\configuration\models;

use Yii;

/**
 * This is the model class for table "conf_subcategory".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $sub_category_id
 * @property integer $ranking
 *
 * @property ConfCategory $category
 * @property ConfCategory $subCategory
 */
class ConfSubcategoryBase extends \engine\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_subcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'sub_category_id'], 'required'],
            [['category_id', 'sub_category_id', 'ranking'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfCategory::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Sub Category ID',
            'ranking' => 'Ranking',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ConfCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(ConfCategory::className(), ['id' => 'sub_category_id']);
    }
}
