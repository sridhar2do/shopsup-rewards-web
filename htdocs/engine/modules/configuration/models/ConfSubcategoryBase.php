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
}
