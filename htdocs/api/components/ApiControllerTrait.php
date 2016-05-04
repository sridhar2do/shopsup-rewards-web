<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace api\components;

use api\components\ErrorResponse;
use engine\components\BaseActiveRecord;
use engine\components\BaseException;
use engine\modules\account\services\AccountService;
use engine\modules\analytics\components\DeviceTrackerBehavior;
use engine\modules\analytics\components\LocatorBehavior;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

/**
 * This is a trait object that is used by all API Controllers.
 */
trait ApiControllerTrait {
	protected $user;
	protected $disableLogin = false;
	
	public $location;
	public $authKey;
	
	/**
	 * Configures all common behaviors for the API actions
	 *
	 * @return array
	 */
	public function behaviors() {
		$behaviors = parent::behaviors ();
		
		$behaviors ['locator'] = [
				'class' => LocatorBehavior::className ()
		];

		$behaviors['deviceTracker'] = [
				'class' => DeviceTrackerBehavior::className()
		];
		
		$behaviors ['authenticator'] = [ 
				'class' => HttpBearerAuth::className () 
		];
		
		$behaviors ['contentNegotiator'] = [ 
				'class' => ContentNegotiator::className (),
				'formatParam' => '_format',
				'formats' => [ 
						'application/json' => Response::FORMAT_JSON 
				] 
		];		
		
		return $behaviors;
	}
	
	/**
	 * Custom method to return validation errors in a model.
	 *
	 * @param BaseActiveRecord $model        	
	 * @param array $data        	
	 * @param string $message        	
	 * @param integer $code        	
	 * @return \api\components\ErrorResponse
	 */
	public function sendModelErrors($model, $data = [], $message = APIMessages::ERROR_DATA_VALIDATION, $code = APICodes::ERROR_DATA_VALIDATION) {
		if (is_array ( $model )) {
			foreach ( $model as $modelObject ) {
				if (! empty ( $modelObject ) && $modelObject->getErrors ()) {
					\Yii::$app->response->setStatusCode ( APICodes::ERROR_DATA_VALIDATION, APIMessages::ERROR_DATA_VALIDATION );
					break;
				}
			}
		} elseif ($model->getErrors ()) {
			\Yii::$app->response->setStatusCode ( APICodes::ERROR_DATA_VALIDATION, APIMessages::ERROR_DATA_VALIDATION );
		}
		
		$object = new ErrorResponse ( $model );
		return $object;
	}
	
	/**
	 * Override the method to run the action by accepting body params as well.
	 *
	 * @param string $id
	 *        	the ID of the action to be executed.
	 * @param array $params
	 *        	the parameters (name-value pairs) to be passed to the action.
	 */
	public function runAction($id, $params) {
		$data = \Yii::$app->getRequest ()->getBodyParams ();
		if (! empty ( $data )) {
			$params = array_merge ( $params, $data );
		}
		
		return parent::runAction ( $id, $params );
	}
	
	/**
	 * Method to run before the action.
	 *
	 * @param Action $action
	 *        	the action to be executed.
	 * @return boolean
	 */
	public function beforeAction($action) {
		
		parent::beforeAction ( $action );
		if (! \Yii::$app->user->isGuest) {
			$this->user = $this->getLoggedInUser ();
		} else {
			$this->user = false;
		}
		
		return true;
	}
	
	/**
	 * Returns the looged in user's identity class
	 *
	 * @return \common\models\User
	 */
	public function getLoggedInUser() {
		return AccountService::model()->getUser(\Yii::$app->user->id);
	}
	
	/**
	 * Method to permit only authenticated users to access the API
	 *
	 * @throws UnauthorizedHttpException
	 */
	public function requireAuthentication() {
		$loggedIn = \Yii::$app->user->isGuest ? false : true;
		if (! $loggedIn) {
			throw new UnauthorizedHttpException ( 'You are requesting with an invalid credential.' );
		}
	}

	/**
	 * Method to permit only guest users to access the API
	 *
	 * @throws UnauthorizedHttpException
	 */
	public function requireGuest() {
		$loggedIn = \Yii::$app->user->isGuest ? false : true;
		if ($loggedIn) {
			throw new UnauthorizedHttpException ( 'You are not allowed to access this resource.' );
		}
	}
	
	/**
	 * Get latitude from header
	 *
	 * @return boolean|float
	 */
	public function getLatitude($strict = true) {
		
		$bodyParams = \Yii::$app->request->getBodyParams ();
		$queryParams = \Yii::$app->request->getQueryParams ();
		if(empty($bodyParams)) {
			$bodyParams = [];
		}
		if(empty($queryParams)) {
			$queryParams = [];
		}
		$params = array_merge ( $bodyParams, $queryParams );
		
		if (! empty ( $params ["latitude"] )) {
			return floatval($params ["latitude"]);
		}
		
		if (! empty ( $this->location ["latitude"] )) {
			return floatval($this->location ["latitude"]);
		}
		
		if (! $strict) {
			return false;
		}
		
		throw new BaseException ( "Missing required parameter - latitude" );
	}
	
	/**
	 * Get longitude from header
	 *
	 * @return boolean|float
	 */
	public function getLongitude($strict = true) {
		$bodyParams = \Yii::$app->request->getBodyParams ();
		$queryParams = \Yii::$app->request->getQueryParams ();
		if(empty($bodyParams)) {
			$bodyParams = [];
		}
		if(empty($queryParams)) {
			$queryParams = [];
		}
		$params = array_merge ( $bodyParams, $queryParams );
		
		if (! empty ( $params ["longitude"] )) {
			return floatval($params ["longitude"]);
		}
		
		if (! empty ( $this->location ["longitude"] )) {
			return floatval($this->location ["longitude"]);
		}
		
		if (! $strict) {
			return false;
		}
		
		throw new BaseException ( "Missing required parameter - longitude" );
	}
	
	/**
	 * Get radius from header
	 *
	 * @return boolean|float
	 */
	public function getRadius() {
		
		$bodyParams = \Yii::$app->request->getBodyParams ();
		$queryParams = \Yii::$app->request->getQueryParams ();
		if(empty($bodyParams)) {
			$bodyParams = [];
		}
		if(empty($queryParams)) {
			$queryParams = [];
		}
		$params = array_merge ( $bodyParams, $queryParams );
		
		if (! empty ( $params ["radius"] )) {
			return floatval($params ["radius"]);
		}
		
		if (! empty ( $this->location ["radius"] )) {
			return floatval($this->location ["radius"]);
		}
		
		return 5000;
	}

	public function getAuthKey() {
		return $this->authKey;
	}
}