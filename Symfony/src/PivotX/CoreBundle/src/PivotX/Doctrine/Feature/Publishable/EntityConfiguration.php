<?php

/*
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\Feature\Publishable;



/**
 * 
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class EntityConfiguration implements \PivotX\Doctrine\Feature\EntityConfiguration
{
    protected $type;

    public function setConfigFromArray(array $array)
    {
        $this->type = $array['type'];
    }
}
