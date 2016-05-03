<?php 

namespace api\components;

use yii\web\HttpException;

class APIHttpException extends HttpException {
	
	public $errors;
	
	public function __construct($status, $message = null, $code = 0, \Exception $previous = null, $model = null)
	{
		
		if($model instanceof ErrorObject) {
			$this->errors = $model->getErrors();
		}

		parent::__construct($status, $message);
		
	}
	
	public function __toString () {
		return "";
	}
	
}


?>