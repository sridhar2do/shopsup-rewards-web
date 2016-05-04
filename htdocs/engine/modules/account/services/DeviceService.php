<?php

namespace engine\modules\account\services;

use engine\modules\account\services\SessionService;
use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccDevice;
use engine\modules\account\models\AccUser;
use engine\modules\account\models\AccUserDevice;
use engine\utils\TimeUtils;

class DeviceService extends BaseService
{

    public function addDevice($token, $authKey = null)
    {
        $device = null;
        try {
            $device = $this->getDevice($token);
            $device->is_active = AccDevice::STATUS_ACTIVE;
            $device->last_active = TimeUtils::getCurrentTimestampForStorage();
            $device->save();
        } catch(BaseException $e) {
            $device = $this->addNewDevice($token);
        }

        if(empty($device) || $device->hasErrors()) {
            throw new BaseException("Could not add the device");
        }

        if(!empty($authKey)) {
            $associate = $this->addToSession($device, $authKey);
            if($associate) {
                return true;
            }

            throw new BaseException("Could not associate the device");
        }

    }

    private function addNewDevice($token) {
        $device = new AccDevice();
        $device->registration_token = $token;
        $device->is_active = AccDevice::STATUS_ACTIVE;
        $device->last_active = TimeUtils::getCurrentTimestampForStorage();
        $device->save();
        return $device;
    }

    private function addToSession(AccDevice $device, $authKey) {
        try {
            $session = SessionService::model()->getSessionByKey($authKey);
        } catch (BaseException $e) {

            return false;
        }

        $exist = AccUserDevice::findOne(["session_id"=>$session->id, "device_id"=>$device->id]);
        if($exist) {
            return true;
        }
        $model = new AccUserDevice();
        $model->session_id = $session->id;
        $model->device_id = $device->id;
        return $model->save();
    }

    public function getDevice($token)
    {
        $result = AccDevice::findOne(["registration_token" => $token]);
        if (!$result) {
            throw new BaseException("Unable to find the device");

        }
        return $result;
    }

}