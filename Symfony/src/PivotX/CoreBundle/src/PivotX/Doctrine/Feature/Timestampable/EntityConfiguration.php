<?php

/*
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\Feature\Timestampable;



/**
 * 
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class EntityConfiguration implements \PivotX\Doctrine\Feature\EntityConfiguration
{
    protected $event_on;

    public function setConfigFromArray(array $array)
    {
        $this->event_on = $array['on'];
    }
}
