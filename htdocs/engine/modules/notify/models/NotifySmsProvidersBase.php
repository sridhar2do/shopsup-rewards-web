<?php

namespace engine\modules\notify\models;

use engine\components\BaseActiveRecord;

/**
 * This is the model class for table "notify_sms_providers".
 *
 * @property integer $id
 * @property string $name
 * @property string $single_api
 * @property string $multiple_api
 * @property string $login_param
 * @property string $login_value
 * @property string $sender_id_param
 * @property string $sender_id_value
 * @property string $password_param
 * @property string $password_value
 * @property string $message_param
 * @property string $single_mobile_param
 * @property string $multiple_mobile_param
 * @property integer $country_code_required
 * @property string $multiple_separator
 * @property double $sent
 * @property integer $status
 * @property string $created_time
 * @property string $updated_time
 */
class NotifySmsProvidersBase extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify_sms_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code_required', 'status'], 'required'],
            [['country_code_required', 'status'], 'integer'],
            [['sent'], 'number'],
            [['created_time', 'updated_time'], 'safe'],
            [['name'], 'string', 'max' => 25],
            [['single_api', 'multiple_api'], 'string', 'max' => 255],
            [['login_param', 'sender_id_param', 'sender_id_value', 'password_param', 'password_value', 'message_param', 'single_mobile_param', 'multiple_mobile_param'], 'string', 'max' => 20],
            [['login_value'], 'string', 'max' => 30],
            [['multiple_separator'], 'string', 'max' => 1]
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
            'single_api' => 'Single Api',
            'multiple_api' => 'Multiple Api',
            'login_param' => 'Login Param',
            'login_value' => 'Login Value',
            'sender_id_param' => 'Sender Id Param',
            'sender_id_value' => 'Sender Id Value',
            'password_param' => 'Password Param',
            'password_value' => 'Password Value',
            'message_param' => 'Message Param',
            'single_mobile_param' => 'Single Mobile Param',
            'multiple_mobile_param' => 'Multiple Mobile Param',
            'country_code_required' => 'Country Code Required',
            'multiple_separator' => 'Multiple Separator',
            'sent' => 'Sent',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }
}
