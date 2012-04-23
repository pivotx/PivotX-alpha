<?php

namespace PivotX\Doctrine\Feature\Multilingual;


class ObjectProperty implements \PivotX\Doctrine\Entity\EntityProperty
{
    private $language_fields;

    public function __construct()
    {
        $this->language_fields = array();

        $this->language_fields[] = 'slug';
        $this->language_fields[] = 'title';
    }

    public function getPropertyMethods()
    {
        $methods = array(
            'getLanguageDependency' => 'generateGetLanguageDependency',
        );

        foreach($this->language_fields as $lf) {
            $methods[\Doctrine\Common\Util\Inflector::camelize('get_'.$lf)] = 'generateGetField:'.$lf;
        }

        return $methods;
    }

    public function generateGetLanguageDependency($entity)
    {
        return <<<THEEND
    /**
     * Returns true if entity is viewable (within the context of this property)
     */
    public function getLanguageDependency()
    {
        // check if the language dependency has been loaded
        // if not load it
        // then return it

        return \$this->language_dependant;
    }

THEEND;
    }

    public function generateGetPublishState($entity)
    {
        return <<<THEEND
    public function getPublishState()
    {
        return \$this->$this->field_publish_state;
    }

THEEND;
    }

    public function generateGetField($entity, $name)
    {
        $functionName = \Doctrine\Common\Util\Inflector::camelize('get_'.$name);

        return <<<THEEND
    public function $functionName()
    {
        return \$this->getLanguageDependency()->$functionName();
    }

THEEND;
    }
}

