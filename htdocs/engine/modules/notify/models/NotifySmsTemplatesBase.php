<?php

namespace engine\modules\notify\models;

use engine\components\BaseActiveRecord;

/**
 * This is the model class for table "notify_sms_templates".
 *
 * @property integer $id
 * @property string $scenario
 * @property string $template
 * @property string $created_time
 */
class NotifySmsTemplatesBase extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify_sms_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template'], 'string'],
            [['created_time'], 'safe'],
            [['scenario'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scenario' => 'Scenario',
            'template' => 'Template',
            'created_time' => 'Created Time',
        ];
    }
}
