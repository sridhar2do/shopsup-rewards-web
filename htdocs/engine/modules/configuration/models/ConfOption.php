<?php

namespace engine\modules\configuration\models;

use common\utils\StringUtils;
use engine\modules\configuration\models\ConfOptionBase;

/**
 * This is the model class for table "mst_tag".
 *
 * @property integer $id
 * @property string $value
 * @property string $type
 *
 * @property CatProductTag[] $catProductTags
 */
class ConfOption extends ConfOptionBase
{

    public function getValue()
    {
        return StringUtils::formatOutput($this->value);
    }
}
