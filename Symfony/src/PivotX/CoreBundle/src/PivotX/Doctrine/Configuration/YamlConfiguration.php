<?php

/*
 * @todo not needed yet
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\Configuration;

use Symfony\Component\Yaml\Yaml;


/**
 * YamlConfiguration
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class YamlConfiguration extends Configuration
{

    public function __construct($filename)
    {
        $array = \Symfony\Component\Yaml\Yaml::parse($filename);

        $this->parseArray($array);
    }

    protected function parseArray($array)
    {
        $this->clearConfiguration();

        //var_dump($array);

        // read auto_entity definitions and parse them into ->fields
        foreach($array as $entity) {
            foreach($entity['fields'] as $field => $definition) {
                if (isset($definition['auto_entity'])) {
                    foreach($definition['auto_entity'] as $feature => $config) {
                        $class = $this->getFeatureClass($feature);
                        if ($class !== false) {
                            $instance = new $class;
                            $instance->setConfigFromArray($config);

                            if (!isset($this->fields[$field])) {
                                $this->fields[$field] = array();
                            }
                            $this->fields[$field][] = $instance;
                        }
                    }
                }
            }
        }
    }
}
