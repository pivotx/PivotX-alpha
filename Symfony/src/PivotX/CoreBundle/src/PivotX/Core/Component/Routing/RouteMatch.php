<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

/**
 * RouteMatch contains a Route that matched
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class RouteMatch
{
    /**
     * Route
     */
    private $route = null;

    /**
     * Arguments
     */
    private $arguments = array();

    /**
     * Constructor.
     *
     * @param Route $route     Route that matched
     * @param arary $arguments Arguments for the route
     */
    public function __construct(Route $route, array $arguments = array())
    {
        $this->setRoute($route);
        $this->setArguments($arguments);
    }

    /**
     * Set the route
     *
     * This method implements a fluent interface.
     *
     * @param Route $route The route
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get the route
     *
     * @return Route The route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set the arguments
     *
     * This method implements a fluent interface.
     *
     * @param array $arguments The arguments
     */
    public function setArguments(array $arguments = array())
    {
        $this->arguments = $arguments;

        return $this;
    }
}
