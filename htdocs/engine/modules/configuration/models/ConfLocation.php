<?php

namespace engine\modules\configuration\models;

use engine\modules\configuration\models\ConfLocationBase;
use engine\utils\FormatUtils;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "mst_location".
 *
 */
class ConfLocation extends ConfLocationBase {
	
	const COUNTRY_TYPE = "COUNTRY";
	const STATE_TYPE = "STATE";
	const CITY_TYPE = "CITY";
	const AREA_TYPE = "AREA";
	
	public function getName() {
		return FormatUtils::getForOutput($this->value);
	}
	
	public function fields() {		
		$fields = [ 
				'id',
				'value',
				'type' 
		];
		
		if($this->type==self::CITY_TYPE){
			$fields = array_merge($fields,['state_name'=>'parentName']);
			$fields = array_merge($fields,['state_id'=>'parent_id']);
		} elseif($this->type==self::STATE_TYPE){
			$fields = array_merge($fields,['country_name'=>'parentName']);
			$fields = array_merge($fields,['country_id'=>'parent_id']);
		} elseif($this->type==self::AREA_TYPE){
			$fields = array_merge($fields,['city_name'=>'parentName']);
			$fields = array_merge($fields,['city_id'=>'parent_id']);
		}
		
		return $fields;
	}
	
	public function extraFields() {
		
		$fields = [];
		
		if($this->type==self::CITY_TYPE){
			$fields = array_merge($fields,['state'=>'parent']);
		} elseif($this->type==self::STATE_TYPE){
			$fields = array_merge($fields,['country'=>'parent']);
		} elseif($this->type==self::AREA_TYPE){
			$fields = array_merge($fields,['city'=>'parent']);
		}
		
		return $fields;
	}

	public static function findLocation($id, $type) {
		return self::findOne ( [ 
				'id' => $id,
				'type' => $type 
		] );
	}
	
	public function getChildren(){		
		return new ActiveDataProvider ( [
				'query' => self::findAll ( [
						'parent_id' => $this->id
				] )
		] );		
	}
	
	public function getParentName(){
		if(!empty($this->parent)) {
			return $this->parent->value;
		}
	}
	
	public static function getProvider($type) {
		return new ActiveDataProvider ( [ 
				'query' => self::findAll ( [
						'type' => $type 
				] ) 
		] );
	}
	
	
}
