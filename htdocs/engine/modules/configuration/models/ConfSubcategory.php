<?php

namespace engine\modules\configuration\models;

/**
 * This is the model class for table "conf_subcategory".
 */
class ConfSubcategory extends ConfSubcategoryBase
{

    public function fields() {
        $fields = parent::fields();

        $fields['s_name'] = 'sName';

        unset( $fields['category_id'], $fields['sub_category_id'] );

        return $fields;
    }

    public function getSName() {
        return $this->subCategory->name;
    }
}