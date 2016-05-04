<?php

namespace engine\modules\account\services;

use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccUserProfile;
use engine\modules\configuration\services\OptionService;

class ProfileService extends BaseService
{

    public function getBasic($user)
    {
        $user = AccountService::model()->getUser($user);
        $profile = $user->accUserProfile;
        if (empty($profile)) {
            $profile = new AccUserProfile();
            $profile->user_id = $user->id;
            if (!$profile->save()) {
                throw new BaseException("Could not get the profile.");
            }
        }

        return $profile;

    }

    public function updateBasic($user, $data)
    {
        $user = AccountService::model()->getUser($user);
        $profile = ProfileService::model()->getBasic($user);

        if (!empty($data["gender"])) {
            $gender = $data["gender"];
            $genderModel = OptionService::model()->getOption($gender, OptionService::TYPE_GENDER, true);
            $data["gender_id"] = $genderModel->id;
            unset($data["gender"]);
        }

        $profile->attributes = $data;
        $profile->user_id = $user->id;
        if (!$profile->save()) {
            throw new BaseException("Could not update the profile.");
        }
        return $profile;
    }



}