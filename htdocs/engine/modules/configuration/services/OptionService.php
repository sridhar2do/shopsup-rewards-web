<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2016 Hyperkonnect Technologies Private Limited
 */
namespace engine\modules\configuration\services;


use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\configuration\models\ConfOption;

class OptionService extends BaseService
{
    const TYPE_GENDER = "GENDER";
    const TYPE_CATALOG_GENDER = "CATALOG_GENDER";

    /**
     * Get the option model. Create a new option if not already in database.
     * Pass $asModel = false to get the return value as the primary key of the option.
     *
     * @param string $value
     * @param string $type
     * @param bool $asModel
     * @throws BaseException
     * @return \engine\modules\configuration\models\ConfOption|number
     */
    public function fetchOption($value, $type, $asModel = false)
    {

        try {
            $model = $this->getOption($value, $type);
            if ($asModel) {
                return $model;
            }
            return $model->id;
        } catch (BaseException $e) {
            $model = new ConfOption ();
        }

        $model->type = $type;
        $model->value = strtolower($value);
        if (!$model->save()) {
            throw new BaseException ("An unknown error occurred while trying to save.");
        }

        if ($asModel) {
            return $model;
        }
        return $model->id;
    }

    /**
     * Get the option model. Throw an error if the model is already in database.
     * Pass $asModel = false to get the return value as the primary key of the option.
     *
     * @param string $value
     * @param string $type
     * @param bool $asModel
     * @throws BaseException
     * @return \engine\modules\configuration\models\ConfOption|number
     */
    public function getOption($value, $type, $asModel = false)
    {

        $type = strtolower($type);

        if ($value instanceof ConfOption) {
            if ($value->type == $type) {
                return $value;
            }
            $value = $value->value;
        }

        $model = ConfOption::findOne([
            'LOWER(type)' => strtolower($type),
            'LOWER(value)' => strtolower($value)
        ]);

        if (!empty ($model)) {
            if ($asModel) {
                return $model;
            }
            return $model->id;
        }

        throw new BaseException ("Could not find the option.");
    }

    /**
     * Get all options of a particular type.
     *
     * @param string $type
     * @param string $asModels
     * @return \yii\db\static[]|string[]
     */
    public function getAllByType($type, $asModels = false)
    {
        $result = [];
        $list = ConfOption::findAll([
            'LOWER(type)' => strtolower($type)
        ]);

        if ($asModels) {
            return $list;
        }
        foreach ($list as $option) {
            $result [$option->id] = strtolower($option->value);
        }

        return $result;
    }

    public function getOptionTextByPK($id, $type = null)
    {
        $model = ConfOption::findOne($id);

        if (empty($model)) {
            throw new BaseException ("Could not find the option.");
        }

        if (!empty($type)) {
            if (strtolower($model->type) != strtolower($type)) {
                throw new BaseException ("Could not find the option.");
            }
        }

        return $model->getValue();
    }
}