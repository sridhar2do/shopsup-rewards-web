<?php

namespace engine\modules\configuration\models;

use engine\components\BaseActiveRecord;
use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $label
 * @property string $value
 * @property string $platform
 */
class ConfSettingBase extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform'], 'string'],
            [['label', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'value' => 'Value',
            'platform' => 'Platform',
        ];
    }
}
