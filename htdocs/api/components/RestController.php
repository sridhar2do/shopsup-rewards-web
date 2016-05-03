<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace api\components;

use api\components\BaseControllerTrait;
use yii\rest\Controller;

/**
 * Custom Controller for API
 */
class RestController extends Controller {
	
	use ApiControllerTrait;
	
	public function init() {
		$data = \Yii::$app->getRequest ()->getBodyParams ();
		$headers = \Yii::$app->request->getHeaders ()->toArray ();
		\Yii::info ( $headers, "headers" );
	}
}

?>