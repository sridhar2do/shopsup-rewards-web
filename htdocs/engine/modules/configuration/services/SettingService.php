<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2016 Hyperkonnect Technologies Private Limited
 */
namespace engine\modules\configuration\services;

use engine\components\BaseService;
use engine\modules\configuration\models\ConfCategory;
use engine\modules\configuration\models\ConfSetting;
use engine\modules\configuration\models\ConfSubcategory;
use engine\modules\configuration\models\RewActivity;


/**
 * Settings and Configuration class.
 */
class SettingService extends BaseService {

	const RADIUS_MIN = "PREFERENCE.LOCATION.RADIUS.MIN";
	const RADIUS_MAX = "PREFERENCE.LOCATION.RADIUS.MAX";
	const RADIUS_DEFAULT = "PREFERENCE.LOCATION.RADIUS.DEFAULT";
	const INVENTORY_RADIUS_MAX = "PREFERENCE.INVENTORY.RADIUS.MAX";

	const EXOTEL_TENANT = "EXOTEL.TENANT";
	const EXOTEL_TOKEN = "EXOTEL.TOKEN";
	const EXOTEL_SERVICE_TYPE = "EXOTEL.SERVICE.TYPE";

	public function getAllSettingsForMobile() {
		$result = [ ];
		$list = ConfSetting::find ()->all ();
		foreach ( $list as $setting ) {
			if ($setting->isForMobile ()) {
				$label = strtoupper ( $setting->label );
				$result [$label] = trim($setting->value);
			}
		}		
		return $result;
	}
	
	public function getSettingForMobile($key) {
		return $this->getSetting($key, ConfSetting::PLATFORM_MOBILE);
	}

	public function getSettingForWeb($key) {
		return $this->getSetting($key, ConfSetting::PLATFORM_WEB);
	}
	
	public function getSetting($key, $platform = false) {
		$result = [ ];		
		if ($platform) {
			$setting = ConfSetting::find ()->where ( [
					"UPPER(label)" => strtoupper ( $key ),
					"platform" => $platform 
			] )->one ();
			if ($setting) {
				return trim($setting->value);
			}
		}
		$setting = ConfSetting::find ()->where ( [
				"UPPER(label)" => strtoupper ( $key ),
				"platform" => ConfSetting::PLATFORM_ALL
		] )->one ();
		if ($setting) {
			return $setting->value;
		}
		
		return false;
	}

	public function getAllCategories() {
		$result = [];
		$result['activities'] = RewActivity::find()->all();
		$result['categories'] = ConfCategory::find()->all();

		return $result;
	}
}