<?php

namespace engine\modules\notify\services;

use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\notify\models\NotifySmsTemplates;

class NotificationService extends BaseService {

    const SCENARIO_MOBILE_VERIFICATION = "USER.MOBILE.VERIFICATION";
    const SCENARIO_USER_PASSWORD_RESET = "USER.PASSWORD.RESET";

    public function sendSMS($mobile, $code, $scenario, $data=null) {
        $scenario = NotifySmsTemplates::findOne(["LOWER(scenario)"=>strtolower($scenario)]);
        if(empty($scenario)) {
            throw new BaseException("Scenario could not be found.");
        }
        $message = $this->substitute($data, $scenario->template);
        return SMSService::model()->sendSingleSMS($message, $code, $mobile);
    }

    private function substitute($data, $template) {

        if(is_array($data)) {
            foreach($data as $key=>$value) {
                $template = str_ireplace($key, $value, $template);
            }
        }

        return $template;
    }

}