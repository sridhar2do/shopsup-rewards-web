<?php

namespace engine\modules\configuration\models;

use engine\modules\configuration\models\ConfSettingBase;

class ConfSetting extends ConfSettingBase {

	const PLATFORM_ALL = "ALL";
	const PLATFORM_WEB = "WEB";
	const PLATFORM_MOBILE = "MOBILE";

	const ACCOUNT_VERIFY_MOBILE = "ACCOUNT.VERIFY.MOBILE";
	
	public function isForMobile() {
		if ($this->platform == self::PLATFORM_ALL || $this->platform == self::PLATFORM_MOBILE) {
			return true;
		}
		return false;
	}

	public function isForWeb() {
		if ($this->platform == self::PLATFORM_ALL || $this->platform == self::PLATFORM_WEB) {
			return true;
		}
		return false;
	}
	
}