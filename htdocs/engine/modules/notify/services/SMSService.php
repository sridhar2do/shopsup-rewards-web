<?php 

namespace engine\modules\notify\services;

use engine\modules\notify\models\NotifySmsLog;
use engine\modules\notify\models\NotifySmsProviders;
use engine\utils\TimeUtils;

class SMSService {
	
	private static $model;
	
	public static function model() {
		if (!empty ( self::$model ) && self::$model instanceof static) {
			return self::$model;
		}
	
		self::$model = new static;
		return self::$model;
	}
	
	const COUNTRY_CODE_REQUIRED = 1;
	const COUNTRY_CODE_NOT_REQUIRED = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	const TYPE_SINGLE = 0;
	const TYPE_BULK = 1;
	const STATUS_SENT = 1;
	const STATUS_FAILED = 0;




	public function sendSingleSMS($message, $code, $number) {
		$providers = NotifySmsProviders::findAll(['status'=>self::STATUS_ACTIVE]);
		$sent = false;
		foreach($providers as $provider) {
			$result = $this->sendSingle($provider, $message, $code, $number);
			if($result != false) {
				$provider->updateCounters(['sent' => 1]);
				$log = new NotifySmsLog();
				$log->message = $message;
				$log->number = "$number";
				$log->type = self::TYPE_SINGLE;
				$log->provider_id = $provider->id;
				$log->response = $result;
				$log->status = self::STATUS_SENT;
				$log->created_time = TimeUtils::getCurrentTimestampForStorage();
				$log->save();
				$sent = true;
				break;
			}
		}
		
		return $sent;
	}
	
	private function sendSingle($provider, $message, $code, $number) {
		
		if(!$provider instanceof NotifySmsProviders) {
			return false;
		}
		
		$mobileNumber = $provider->country_code_required == self::COUNTRY_CODE_REQUIRED ? $code.$number : $number;
		
		$ch = curl_init ();
			
		$data = array ();
		$data ["$provider->login_param"] = $provider->login_value;
		$data ["$provider->sender_id_param"] = $provider->sender_id_value;
		$data ["$provider->password_param"] = $provider->password_value;
		$data ["$provider->message_param"] = $message;
		$data ["$provider->single_mobile_param"] = $mobileNumber;	
			
		$agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:37.0) Gecko/20100101 Firefox/37.0';
		curl_setopt ( $ch, CURLOPT_URL, "$provider->single_api" );
		curl_setopt ( $ch, CURLOPT_USERAGENT, $agent );			
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$server_output = curl_exec ( $ch );		
		curl_close ( $ch );
		
		return $server_output;
		
	}
	
	private function sendBulk($provider, $message, $code, $number) {
	
	}
	
	
}

?>