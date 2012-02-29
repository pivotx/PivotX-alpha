<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

/**
 * Route describes a PivotX route.
 *
 * @todo should this be smartly merged with Symfony\Component\Routing\Route?
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Route
{
    /**
     * Entity used
     */
    private $entity = false;

    /**
     * Public url
     */
    private $url = false;

    /**
     * Set the defaults
     */
    private $defaults = false;
}
