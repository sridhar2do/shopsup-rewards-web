<?php

namespace api\controllers;

use yii\web\Controller;
use core\wrappers\AuthenticationWrapper;

/**
 * Site controller
 */
class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				] 
		];
	}
	
	public function actionIndex() {		
		return $this->render ( 'index' );
	}
}
