<?php

namespace PivotX\Doctrine\Feature\Sluggable;


class ObjectProperty implements \PivotX\Doctrine\Entity\EntityProperty
{
    private $field_slug = 'slug';
    private $field_slug_field = 'title';

    public function __construct()
    {
    }

    public function getPropertyMethods()
    {
        return array(
            'generateSlug' => 'generateGenerateSlug',
        );
    }

    public function generateGenerateSlug($entity)
    {
        return <<<THEEND
    /**
     */
    public function generateSlug()
    {
        \$this->$this->field_slug = preg_replace('|[^a-z0-9-]+|','-',\$this->$this->field_slug_field);

        return \$this;
    }

THEEND;
    }
}

