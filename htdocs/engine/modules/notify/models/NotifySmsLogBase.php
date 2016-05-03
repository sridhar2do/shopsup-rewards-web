<?php

namespace engine\modules\notify\models;

use engine\components\BaseActiveRecord;

/**
 * This is the model class for table "notify_sms_log".
 *
 * @property integer $id
 * @property string $message
 * @property integer $type
 * @property string $number
 * @property integer $provider_id
 * @property string $response
 * @property integer $status
 * @property string $created_time
 */
class NotifySmsLogBase extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify_sms_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'required'],
            [['type', 'provider_id', 'status'], 'integer'],
            [['number', 'response'], 'string'],
            [['created_time'], 'safe'],
            [['message'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'type' => 'Type',
            'number' => 'Number',
            'provider_id' => 'Provider ID',
            'response' => 'Response',
            'status' => 'Status',
            'created_time' => 'Created Time',
        ];
    }
}
