<?php

namespace engine\modules\configuration\models;

/**
 * This is the model class for table "conf_category".
 */
class ConfCategory extends ConfCategoryBase
{

    public function fields() {
        $fields = parent::fields();
        $fields["sub"] = "confSubcategories";
//        var_dump($fields); die();

        return $fields;
    }
    
}
