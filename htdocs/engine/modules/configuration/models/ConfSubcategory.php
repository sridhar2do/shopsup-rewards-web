<?php

namespace engine\modules\configuration\models;

use Yii;

/**
 * This is the model class for table "conf_subcategory".
 */
class ConfSubcategory extends ConfSubcategoryBase
{

    public function fields() {
        $fields = parent::fields();

        $fields['c_name'] = 'cName';
        $fields['s_name'] = 'sName';

//        var_dump( $fields ); die();

        unset( $fields['category_id'], $fields['sub_category_id'] );

//        return ['id ', 'c_name', 's_name'];
        return $fields;
    }

    public function getCName() {
        return $this->category->name;
    }

    public function getSName() {
        return $this->subCategory->name;
    }
}