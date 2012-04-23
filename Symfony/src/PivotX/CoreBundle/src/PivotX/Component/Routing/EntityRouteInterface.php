<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Routing;

/**
 * EntityInterface is the interface that all Entity classes must implement.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
interface EntityRouteInterface
{
    public function setName($name);
    public function getName();

    public function setDescription($description);
    public function getDescription();
}
