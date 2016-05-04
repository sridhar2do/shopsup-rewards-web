<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2016 Hyperkonnect Technologies Private Limited
 */

namespace engine\modules\account\models;

use engine\modules\account\models\AccUserProfileBase;
use engine\modules\configuration\services\OptionService;


class AccUserProfile extends AccUserProfileBase {

    public function fields() {
        return [
            "user_id",
            "first_name",
            "last_name",
            "gender"=>'genderText',
            "date_of_birth",
        ];
    }

    public function getGenderText() {
        if(!empty($this->gender)) {
            return OptionService::model()->getOptionTextByPK($this->gender->id);
        }

        return "";
    }

}