<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2015 Hyperkonnect Technologies Private Limited
 */
namespace engine\components;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This class is the Base class for all active record classes.
 */
abstract class BaseActiveRecord extends ActiveRecord {
	
	private $_fieldData = [ ];
	protected $hiddenFields = [ ];
	
	/**
	 * Add a field to the list of fields
	 * 
	 * @param array|string $data
	 */
	public function addField($data) {
		$this->_fieldData = array_merge ( $this->_fieldData, $data );
	}
	
	/**
	 * {@inheritDoc}
	 * @see \yii\db\BaseActiveRecord::fields()
	 */
	public function fields() {
		$fields = parent::fields ();
		$fields = array_merge ( $fields, $this->_fieldData );
		
		foreach ( $this->hiddenFields as $hiddenField ) {
			if (isset ( $fields [$hiddenField] )) {
				unset ( $fields [$hiddenField] );
			}
		}
		return $fields;
	}
	
	/**
	 * Implements null fields functionality for the active records.
	 * The PDO does not return empty string for Date and certain other fields.
	 * The Android JSON parser requires Date field to hold empty string instead of NULL.
	 *
	 * Return an array of all fields that have to be set as empty string before returning the model.
	 */
	public function nullFields() {
		return [ ];
	}
	
	/**
	 * Overrides parent's afterFind() method.
	 *
	 * {@inheritDoc}
	 *
	 * @see \yii\db\BaseActiveRecord::afterFind()
	 */
	public function afterFind() {
		$nullFields = $this->nullFields ();
		
		foreach ( $nullFields as $nullField ) {
			if (empty ( $this->$nullField ))
				$this->$nullField = "";
		}
		
		parent::afterFind ();
	}
	
	/**
	 * Overrides parent's hasOne method.
	 *
	 *
	 * Allows to fetch one to one relationship records with a where condition.
	 * Default implementation does not support fetching relationship records with a where condition.
	 *
	 * {@inheritDoc}
	 *
	 * @see \yii\db\ActiveRecord::hasOne($class, $link)
	 */
	public function hasOne($class, $link, $where = false) {
		/* @var $class ActiveRecordInterface */
		/* @var $query ActiveQuery */
		if (! $where)
			return parent::hasOne ( $class, $link );
		
		$query = $class::find ()->where ( $where );
		$query->primaryModel = $this;
		$query->link = $link;
		$query->multiple = false;
		return $query;
	}
	
	/**
	 * Overrides parent's hasMany method.
	 *
	 * Allows to fetch one to many relationship records with a where condition.
	 * Default implementation does not support fetching relationship records with a where condition.
	 *
	 * {@inheritDoc}
	 *
	 * @see \yii\db\ActiveRecord::hasOne($class, $link)
	 */
	public function hasMany($class, $link, $where = false) {
		/* @var $class ActiveRecordInterface */
		/* @var $query ActiveQuery */
		if (! $where)
			return parent::hasMany ( $class, $link );
		
		$query = $class::find ()->where ( $where );
		$query->primaryModel = $this;
		$query->link = $link;
		$query->multiple = true;
		return $query;
	}
	
	/**
	 * Static method to return an Active Data Provider for the current class.
	 *
	 *
	 * @return ActiveDataProvider
	 */
	public static function getAllProvider() {
		return new ActiveDataProvider( [ 
				'query' => self::find () 
		] );
	}
	
	/**
	 * Static method to return an Active Data Provider for the current class.
	 *
	 * @return ActiveDataProvider
	 */
	public static function getAll() {
		return self::find ()->all();
	}
	
	/**
	 * Static method to insert bulk data in the database.
	 * Accepts an array of active record objects.
	 *
	 * @param BaseActiveRecord $models        	
	 * @return boolean|number
	 */
	public static function bulkInsert($models) {
		if (empty ( $models ))
			return 0;
		
		$newModels = [ ];
		
		foreach ( $models as $model ) {
			if ($model->validate ()) {
				$newModels [] = $model->attributes;
			} else {
				return false;
			}
		}
		
		$bulkModel = new static ();
		return \Yii::$app->db->createCommand ()->batchInsert ( self::tableName (), $bulkModel->attributes (), $newModels )->execute ();
	}
}