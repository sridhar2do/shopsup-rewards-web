<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace app\modules\v1\controllers;

use api\components\RestController;
use api\components\ResultObject;
use api\forms\BasicProfileForm;
use common\constants\APICodes;
use common\constants\APIMessages;
use core\facades\UserFacade;
use yii\web\HttpException;
use core\modules\account\models\AccUser;
use core\modules\master\services\OptionService;

/**
 * This class handles all API requests related to a user's profile.
 *
 * This class handles the following actions - get the basic information of a user,
 * get advanced information of a user, get available fields for a user, post basic info,
 * post advanced info.
 */
class ProfileController extends RestController {
	
	/**
	 * Action that returns a basic profile of the logged in user.
	 *
	 * @return \api\components\ResultObject|\core\modules\account\models\AccUserProfile
	 */
	
	public function actionGetBasic() {
		
		// require authentication
		$this->requireAuthentication();
		
		$userFacade = new UserFacade ();
		$profile = $userFacade->getBasicProfile ( $this->user->id );
		if (empty ( $profile ) || ! $profile) {
			return new ResultObject ( APICodes::SUCCESS_OPERATION, APIMessages::INFO_USER_PROFILE_NOT_FOUND, true );
		}
		return $profile;
	}
	
	/**
	 * Action that allows user to update his profile information.
	 *
	 * @param string $first_name        	
	 * @param string $last_name        	
	 * @param string $city_id        	
	 * @param string $mobile        	
	 * @param string $date_of_birth        	
	 * @param string $gender        	
	 * @param string $mobile_code        	
	 * @throws HttpException
	 * @return \api\components\ResultObject
	 */
	public function actionPostBasic($first_name="", $last_name="", $city_id = "", $date_of_birth = "", $gender = "", $email = "", $mobile="") {
		
		// require authentication
		$this->requireAuthentication();
		
		$user = $this->getLoggedInUser ();
		$form = new BasicProfileForm ();
		$form->initialize ( $user->id );
		$data = \Yii::$app->getRequest ()->getBodyParams ();
		
		$form->attributes = $data;
		$form->first_name = isset ( $data ['first_name'] ) && $data ['first_name'] ? $data ['first_name'] : $first_name;
		$form->last_name = isset ( $data ['last_name'] ) && $data ['last_name'] ? $data ['last_name'] : $last_name;
		$form->date_of_birth = isset ( $data ['date_of_birth'] ) && $data ['date_of_birth'] ? $data ['date_of_birth'] : $date_of_birth;
		$form->gender = isset ( $data ['gender'] ) && $data ['gender'] ? OptionService::model ()->getOption ( $data ['gender'], OptionService::TYPE_GENDER ) : "";
		$form->email =  isset ( $data ['email'] ) && $data ['email'] ? $data ['email'] : $email;
		$form->mobile =  isset ( $data ['mobile'] ) && $data ['mobile'] ? $data ['mobile'] : $mobile;
		
		if ($form->save ()) {
			AccUser::$showProfile = true;
			return $user;
		}
		
		$this->sendModelErrors ( $form );
	}
	
	public function getProfilePic() {
	}
	
	public function postProfilePic() {
	}
	
	public function actionGetAdvanced() {
	}
	
	public function actionPostAdvanced() {
	}
	
	public function actionGetFields() {
	}
}