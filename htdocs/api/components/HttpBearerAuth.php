<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace api\components;

use yii\filters\auth\AuthMethod;
use Yii;

/**
 * Class to handle API authentication
 */
class HttpBearerAuth extends AuthMethod {
	
	/**
	 *
	 * @var string the HTTP authentication realm
	 */
	public $realm = 'api';
	public $ownerAuthKeyProperty = "authKey";
	public function beforeAction($action) {
		$response = $this->response ?  : Yii::$app->getResponse ();
		
		$identity = $this->authenticate ( $this->user ?  : Yii::$app->getUser (), $this->request ?  : Yii::$app->getRequest (), $response );
		
		return true;
	}
	
	/**
	 * @inheritdoc
	 */
	public function authenticate($user, $request, $response) {
		$authHeader = $request->getHeaders ()->get ( 'Authorization' );
		if ($authHeader !== null && preg_match ( "/^Bearer\\s+(.*?)$/", $authHeader, $matches )) {
			$identity = $user->loginByAccessToken ( $matches [1], get_class ( $this ) );
			$owner = $this->owner;
			$authKeyProperty = $this->ownerAuthKeyProperty;
			if (property_exists ( $owner, $authKeyProperty )) {
				$owner->$authKeyProperty = $matches [1];
			}
			if ($identity !== null) {
				return $identity;
			}
		}
		
		return null;
	}
	
	/**
	 * @inheritdoc
	 */
	public function challenge($response) {
		$response->getHeaders ()->set ( 'WWW-Authenticate', "Bearer realm=\"{$this->realm}\"" );
	}
}
