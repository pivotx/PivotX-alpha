<?php

namespace PivotX\Doctrine\Feature\Crudable;


class ObjectProperty implements \PivotX\Doctrine\Entity\EntityProperty
{
    public function __construct()
    {
    }

    public function getPropertyMethods()
    {
        return array(
            'crudGetRowClass' => 'generateGetRowClass'
        );
    }

    public function generateGetRowClass($entity)
    {
        return <<<THEEND
    /**
     * Returns relevant classes to add in the row html
     */
    public function crudGetRowClass()
    {
        \$classes = array();

        // we need to make a check if Publishable is available at all
        if (\$this->isPublished()) {
            \$classes[] = 'publish-state-published';
        }
        else {
            \$classes[] = 'publish-state-depublished';
        }
    
        return implode(' ',\$classes);
    }

THEEND;
    }
}

