<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace api\components;

use yii\base\Arrayable;

/**
 * This is the object that sends validation errors in the model.
 */
class ErrorResponse implements Arrayable {
	public $code;
	public $message;
	public $model;
	private $errors = [ ];
	private $data = [ ];
	
	/**
	 * Add an data by key
	 *
	 * @param string $key        	
	 * @param string $value        	
	 * @return boolean
	 */
	public function setData($key, $value) {
		$this->data [$key] = $value;
		return true;
	}
	
	/**
	 * Get the value of a data by key
	 *
	 * @param string $key        	
	 * @return mixed|boolean
	 */
	public function getData($key) {
		if (isset ( $this->data [$key] )) {
			return $this->data [$key];
		}
		return false;
	}
	
	/**
	 * Add an error message by key
	 *
	 * @param string $key        	
	 * @param string $value        	
	 * @return boolean
	 */
	public function setError($key, $value) {
		$this->errors [$key] = $value;
		return true;
	}
	
	/**
	 * Get the error message by key
	 *
	 * @param string $key        	
	 * @return mixed|boolean
	 */
	public function getError($key) {
		if (isset ( $this->errors [$key] ))
			return $this->errors [$key];
		return false;
	}
	
	/**
	 *
	 * @param \yii\base\Model|\yii\base\Model[] $model        	
	 * @param array $data        	
	 * @param string $message        	
	 * @param integer $code        	
	 */
	public function __construct($model, $data = [], $message = APIMessages::ERROR_DATA_VALIDATION, $code = APICodes::ERROR_DATA_VALIDATION) {
		$this->code = $code;
		$this->model = $model;
		$this->message = $message;
		
		$errors = [ ];
		
		// if input is an array get all of the messages from each of the models
		if (is_array ( $model )) {
			foreach ( $model as $modelObject ) {
				$errors = array_merge ( $errors, $modelObject->getFirstErrors () );
			}
		} else {
			// get the messages from the model
			$errors = $model->getFirstErrors ();
		}
		
		// if messages is not empty add the errors to the property array
		if (! empty ( $errors )) {
			foreach ( $errors as $key => $value ) {
				if (is_array ( $value ))
					$this->setError ( $key, implode ( ",", $value ) );
				else
					$this->setError ( $key, $value );
			}
		}
		
		if (! empty ( $data )) {
			foreach ( $data as $key => $value ) {
				$this->setData ( $key, $value );
			}
		}
	}
	
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \yii\base\Arrayable::fields()
	 */
	public function fields() {
		$fields = [ 
				'code',
				'message' 
		];
		
		if (! empty ( $this->errors ) && is_array ( $this->errors )) {
			$fields ['error_fields'] = "errors";
		}
		
		return $fields;
	}
	
	/**
	 * Get the list of error messages for the model(s).
	 *
	 * @return string[]
	 */
	public function getErrors() {
		$result = [ ];
		$result = $this->toArray ();
		
		$errors = [ ];
		if (! empty ( $this->errors ) && is_array ( $this->errors )) {
			foreach ( $this->errors as $label => $value ) {
				if (is_array ( $value )) {
					$errors [$label] = implode ( ", ", $value );
				} else {
					$errors [$label] = $value;
				}
			}
		}
		
		$result ['error_list'] = $errors;
		
		return $result;
	}
	
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Arrayable::extraFields()
	 */
	public function extraFields() {
		return [ ];
	}
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Arrayable::toArray()
	 */
	public function toArray(array $fields = [], array $expand = [], $recursive = true) {
		$fieldList = empty ( $fields ) ? $this->fields () : $fields;
		
		$data = [ ];
		
		foreach ( $fieldList as $field ) {
			$data [$field] = $this->$field;
		}
		
		return $data;
	}
	
	/**
	 * @param string $value
	 * @return mixed|string
	 */
	public function __get($value) {
		if (isset ( $this->data [$value] )) {
			return $this->data [$value];
		}
		
		$funcName = "get" . ucfirst ( $value );		
		if (method_exists ( $this, $funcName )) {
			
			return $this->$funcName ();
		}		
		return "";
	}
}


