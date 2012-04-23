<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Routing;

use PivotX\Component\Referencer\Reference;

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
        $this->routesetup = $routesetup;
        $this->routesetup->addRoutePrefixes($this);

        return $this;
    }

    /**
     * Add a RoutePrefix
     *
     * @param array $filter            Filter for this prefix
     * @param RoutePrefix $routeprefix Prefix to add
     */
    public function add(array $filter, RoutePrefix $routeprefix)
    {
        // @todo throw error if not already simplifyFilter
        $n_filter = $this->routesetup->simplifyFilter($filter);

        $routeprefix->setFilter($n_filter);

        $idx              = count($this->prefixes);
        $this->prefixes[] = $routeprefix;

        return $this;
    }

    /**
     * Try to find a prefix that matches this URL
     *
     * @param string $url  Url to match
     * @return RoutePrefix Prefix that matched or null if none found
     */
    public function matchUrl($url)
    {
        foreach($this->prefixes as $prefix) {
            if ($prefix->matchUrl($url)) {
                return $prefix;
            }
        }

        return null;
    }

    /**
     * Try to find a prefix that matches this Reference
     *
     * @param Reference $reference Reference to match
     * @return RoutePrefix         Prefix that matched or null if none found
     */
    public function matchReference(Reference $reference)
    {
        foreach($this->prefixes as $prefix) {
            if ($prefix->matchReference($reference)) {
                return $prefix;
            }
        }

        return null;
    }

    /**
     * Try to find a prefix that matches this filter
     *
     * @todo replace this bruto-force implementation
     *
     * @param array $filter  Filter to match
     * @return RoutePrefix   Prefix that matched or null if none found
     */
    public function matchFilter(array $filter)
    {
        $n_filter = $this->routesetup->simplifyFilter($filter);

        foreach($this->prefixes as $prefix) {
            if ($prefix->matchFilter($n_filter)) {
                return $prefix;
            }
        }

        return null;
    }
}
