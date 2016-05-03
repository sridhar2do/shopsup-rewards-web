<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace api\components;

use api\components\BaseControllerTrait;
use yii\rest\ActiveController;

/**
 * Custom Active Controller for API
 */
class RestActiveController extends ActiveController {
	
	use ApiControllerTrait;
	public function init() {
	}
}

?>