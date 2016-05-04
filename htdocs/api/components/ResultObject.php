<?php

namespace api\components;

use api\components\APICodes;
use api\components\APIMessages;
use yii\base\Arrayable;

class ResultObject implements Arrayable {
	
	public $code;
	public $message;
	public $success;
	private $data = [ ];
	
	public function __construct($code = APICodes::SUCCESS_OPERATION, $message = APIMessages::SUCCESS_GENERIC, $success = true, $data = []) {
		
		$this->code = $code;
		$this->message = $message;
		$this->success = $success;
		
		foreach($data as $key=>$value)
			$this->setData($key, $value);
		
	}
	
	public function setData($key, $value) {
		$this->data [$key] = $value;
		return true;
	}
	
	public function getData($key) {
		if (isset ( $this->data [$key] ))
			return $this->data [$key];
		return false;
	}
	
	public function fields() {
		$fields = [ 
				'code',
				'message',
				'success' 
		];
		if (! empty ( $this->data ) && is_array ( $this->data )) {
			foreach ( $this->data as $label => $value ) {
				$fields [$label] = $value;
			}
		}
		
		return $fields;
	}
	
	public function extraFields() {
		return [ ];
	}
	
	public function toArray(array $fields = [], array $expand = [], $recursive = true) {
		$fieldList = empty ( $fields ) ? $this->fields () : $fields;
		
		$data = [ ];
		
		foreach ( $fieldList as $field ) {
			$data [$field] = $this->$field;
		}
		
		return $data;
	}
}


