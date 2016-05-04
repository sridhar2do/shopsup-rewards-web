<?php

namespace engine\modules\analytics\components;

use engine\components\BaseException;
use engine\modules\account\services\DeviceService;
use yii\base\Behavior;
use yii\web\Controller;

class DeviceTrackerBehavior extends Behavior {
	
	public $ownerAuthKeyProperty = "authKey";

	public $registrationTokenHeader = "Device-registration-token";

	public function events() {
		
		return [ 
				Controller::EVENT_AFTER_ACTION => 'traceDevice'
		];
		
	}
	
	public function traceDevice($event) {
		
		$request = \Yii::$app->request;
		
		$registrationToken = $request->getHeaders ()->get ( $this->registrationTokenHeader, false, true );
		$authKey = null;
		$owner = $this->owner;

		$authKeyProperty = $this->ownerAuthKeyProperty;

		if (property_exists ( $owner, $authKeyProperty )) {
			$authKey = $owner->$authKeyProperty;
		}
		
		if ( ! $registrationToken) {
			return true;
		}

		try {
			DeviceService::model()->addDevice($registrationToken, $authKey);
		} catch (BaseException $e) {
			return false;
		}

	}
}