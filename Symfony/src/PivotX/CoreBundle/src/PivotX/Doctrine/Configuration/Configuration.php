<?php

/*
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\Configuration;



/**
 * 
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class Configuration
{
    protected $feature_classes;
    protected $fields;

    /**
     */
    protected function clearConfiguration()
    {
        $this->feature_classes = array();
        $this->fields          = array();
    }

    /**
     * Return the feature class based on name
     *
     * @todo only works for PivotX stuff now
     */
    protected function getFeatureClass($name)
    {
        $class = '\\PivotX\\Doctrine\\Feature\\'.ucfirst($name).'\\EntityConfiguration';
        if (class_exists($class)) {
            return new $class;
        }

        return false;
    }

    /**
     */
    public function getFeatures()
    {
    }

    /**
     * Return all the features for a particular field
     *
     * @param string $name
     * @return array       features supported
     */
    public function getFieldFeaturesByName($name)
    {
        if (isset($this->fields[$name])) {
            return $this->fields[$name];
        }

        return array();
    }
}
