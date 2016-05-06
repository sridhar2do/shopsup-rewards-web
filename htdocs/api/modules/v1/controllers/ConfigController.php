<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace app\modules\v1\controllers;

use api\components\RestController;
use engine\modules\configuration\services\SettingService;
use yii\web\HttpException;

class ConfigController extends RestController
{
    public function actionGetAllForMobile()
    {
        $result = SettingService::model()->getAllSettingsForMobile();
        return $result;
    }

    public function actionGetForMobile($key)
    {
        $result = SettingService::model()->getSettingForMobile($key);
        if ($result === false) {
            throw new HttpException (404, "The configuration could not be found.");
        }
        return $result;
    }

    public function actionGetAllCategories() {

        $result = SettingService::model()->getAllCategories();

        return $result;
    }
}