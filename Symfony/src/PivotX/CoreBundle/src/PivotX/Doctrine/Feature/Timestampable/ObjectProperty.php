<?php

namespace PivotX\Doctrine\Feature\Timestampable;


class ObjectProperty implements \PivotX\Doctrine\Entity\EntityProperty
{
    private $field_created_date = 'date_created';
    private $field_modified_date = 'date_modified';

    public function __construct()
    {
    }

    public function getPropertyMethods()
    {
        return array(
            'getCrudIgnore_'.$this->field_created_date => 'generateGetCrudIgnoreCreatedDate',
            'getCrudIgnore_'.$this->field_modified_date => 'generateGetCrudIgnoreModifiedDate',
        );
    }

    public function generateGetCrudIgnoreCreatedDate()
    {
        $field = $this->field_created_date;
        return <<<THEEND
    /**
     */
    public function getCrudIgnore_$field()
    {
        return true;
    }
THEEND;
    }

    public function generateGetCrudIgnoreModifiedDate()
    {
        $field = $this->field_modified_date;
        return <<<THEEND
    /**
     */
    public function getCrudIgnore_$field()
    {
        return true;
    }
THEEND;
    }
}

