<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

use PivotX\Core\Component\Referencer\Reference;

/**
 * RouteCollection collects all Route statements
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class RouteCollection
{
    /**
     * RouteSetup
     */
    private $routesetup = false;

    /**
     * Routes
     */
    private $routes = array();


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
        $this->routesetup = $routesetup;
        $this->routesetup->addRouteCollection($this);

        return $this;
    }

    /**
     * Add a Route
     *
     * @param array $filter Filter for this prefix
     * @param Route $route  Prefix to add
     */
    public function add(array $filter, Route $route)
    {
        $n_filter = $this->routesetup->normalizeFilter($filter);

        $route->setFilter($n_filter);

        $idx            = count($this->routes);
        $this->routes[] = $route;

        return $this;
    }

    /**
     * Try to find a route that matches this URL
     *
     * @param array $filter Simplified filter to match
     * @param string $url   Url to match
     * @return RouteMatch   Route that matched or null if none found
     */
    public function matchUrl($filter, $url)
    {
        $n_filter = $this->routesetup->simplifyFilter($filter);

        foreach($this->routes as $route) {
            $routematch = $route->matchUrl($n_filter, $url);
            if ($routematch !== false) {
                return $routematch;
            }
        }

        return null;
    }

    /**
     * Try to find a route that matches this Reference
     */
    public function matchReference(Reference $reference)
    {
        $filter = $reference->getRouteFilter();

        foreach($this->routes as $route) {
            $routematch = $route->matchReference($filter, $reference);
            if ($routematch !== false) {
                return $routematch;
            }
        }

        return null;
    }
}
