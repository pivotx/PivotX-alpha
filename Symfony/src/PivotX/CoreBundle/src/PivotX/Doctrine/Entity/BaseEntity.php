<?php

namespace PivotX\Doctrine\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 */
class BaseEntity
{
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createField('id', 'integer')->isPrimaryKey()->generatedValue()->build();
        $builder->addField('publicid', 'string');
    }

    public function __getProperty($iname)
    {
        if (property_exists($this,$iname)) {
            return $this->$iname;
        }
    }

    public function __call($name, $args)
    {
        if (substr($name,0,3) == 'get') {
            $iname = \Symfony\Component\DependencyInjection\Container::underscore(substr($name,3));
            return $this->getProperty($iname);
        }
        else if (substr($name,0,6) == 'isNull') {
            $iname = \Symfony\Component\DependencyInjection\Container::underscore(substr($name,6));
            if (property_exists($this,$iname)) {
                return is_null($this->$iname);
            }
        }
        else if (substr($name,0,3) == 'set') {
            $iname = \Symfony\Component\DependencyInjection\Container::underscore(substr($name,3));
            if (property_exists($this,$iname)) {
                $this->$iname = $args[0];
            }
        }
    }
}
