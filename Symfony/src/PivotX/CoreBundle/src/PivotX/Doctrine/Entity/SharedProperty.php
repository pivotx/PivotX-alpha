<?php

namespace PivotX\Doctrine\Entity;


class SharedProperty implements EntityProperty
{
    public function getPropertyMethods()
    {
        return array(
            /*
            'getId' => 'generateGetId',
            '__call' => 'generate__Call',
            '__get' => 'generate__Get',
            '__set' => 'generate__Set'
            //*/
        );
    }

    public function generateGetId($entity)
    {
        return <<<THEEND
    public function getId()
    {
        return 1;
    }

THEEND;
    }

    public function generate__Call($entity)
    {
        return <<<THEEND
    public function __call(\$name, \$args = array())
    {
        // @todo should log this call or throw Exception
        return false;
    }

THEEND;
    }

    public function generate__Set($entity)
    {
        return <<<THEEND
    public function __set(\$name, \$value)
    {
    }

THEEND;
    }

    public function generate__Get($entity)
    {
        return <<<THEEND
    public function __get(\$name)
    {
        return false;
    }

THEEND;
    }
}
