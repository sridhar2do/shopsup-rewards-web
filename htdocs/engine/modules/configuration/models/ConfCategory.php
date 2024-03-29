<?php

namespace engine\modules\configuration\models;
use engine\modules\configuration\services\SettingService;

/**
 * This is the model class for table "conf_category".
 */
class ConfCategory extends ConfCategoryBase
{

    public function fields() {
        $fields = parent::fields();

        $fields["subcategories"] = "confSubcategories";

        return $fields;
    }
    
}
