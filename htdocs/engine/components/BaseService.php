<?php

/**
 * @author Karthick Loganathan
 * @copyright Copyright (c) 2016 Hyperkonnect Technologies Private Limited
 */
namespace engine\components;

/**
 * This is the parent service class for all services.
 */
class BaseService
{
    private static $model;

    /**
     * Private constructor to implement singleton.
     */
    private function __construct()
    {
        $this->init();
        return $this;
    }

    /**
     * Override this method to implement any startup activities.
     */
    protected function init()
    {
    }

    /**
     * Static method to get an instance of the service object.
     *
     * @return $this
     */
    public static function model()
    {
        if (!empty (self::$model) && self::$model instanceof static) {
            return self::$model;
        }

        self::$model = new static ();
        return self::$model;
    }
}