<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

/**
 * RoutePrefixes collects all RoutePrefix statements
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class RoutePrefixes
{
    /**
     * RouteSetup
     */
    private $routesetup = false;

    /**
     * Prefixes
     */
    private $prefixes = array();


    /**
     * Constructor.
     *
     * @param RouteSetup $setup  The RouteSetup
     */
    public function __construct(RouteSetup $setup)
    {
        $this->setRouteSetup($setup);
    }

    /**
     * Set the route setup
     *
     * This method implements a fluent interface.
     *
     * @param RouteSetup $routesetup The route setup
     */
    public function setRouteSetup(RouteSetup $routesetup)
    {
        $this->routesetp = $routesetup;

        return $this;
    }

    /**
     */
}
