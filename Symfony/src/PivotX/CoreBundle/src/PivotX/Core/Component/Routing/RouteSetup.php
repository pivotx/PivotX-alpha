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
class RouteSetup
{
    /**
     * All the routeprefixeses
     */
    private $routeprefixeses = array();

    /**
     */
    private $routecollections = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Add routeprefixes
     *
     * This method implements a fluent interface.
     *
     * @param RoutePrefixes $routeprefixes RoutePrefixes to add
     */
    public function addRoutePrefixes(RoutePrefixes $routeprefixes)
    {
        $this->routeprefixeses[] = $routeprefixes;

        return $this;
    }

    /**
     * Add routecollection
     *
     * This method implements a fluent interface.
     *
     * @param RouteColection $routecollection RouteCollection to add
     */
    public function addRouteCollection(RouteCollection $routecollection)
    {
        $this->routecollections[] = $routecollection;

        return $this;
    }

    /**
     * Search for a Reference
     *
     * @todo brute-force method used now, should be optimised
     *
     * @param Reference $reference   Reference to search for
     * @return RouteMatch RouteMatch if found, otherwise null
     */
    public function matchReference(Reference $reference)
    {
        $routeprefix = null;
        $routematch  = null;

        foreach($this->routeprefixeses as $routeprefixes) {
            $routeprefix = $routeprefixes->matchReference($reference);
            if (!is_null($routeprefix)) {
                break;
            }
        }

        if (!is_null($routeprefix)) {
            //$route_url = str_replace($routeprefix->getPrefix(),'',$url);
            $filter    = $routeprefix->getFilter();

            foreach($this->routecollections as $routecollection) {
                $routematch = $routecollection->matchReference($filter,$reference);
                if (!is_null($routematch)) {
                    break;
                }
            }
        }

        return $routematch;
    }

    /**
     * Search for an URL
     *
     * @todo brute-force method used now, should be optimised
     *
     * @param string $url Url to search for
     * @return RouteMatch RouteMatch if found, otherwise null
     */
    public function matchUrl($url)
    {
        $routeprefix = null;
        $routematch  = null;

        foreach($this->routeprefixeses as $routeprefixes) {
            $routeprefix = $routeprefixes->matchUrl($url);
            if (!is_null($routeprefix)) {
                break;
            }
        }

        if (!is_null($routeprefix)) {
            $route_url = str_replace($routeprefix->getPrefix(),'',$url);
            $filter    = $routeprefix->getFilter();

            foreach($this->routecollections as $routecollection) {
                $routematch = $routecollection->matchUrl($filter,$route_url);
                if (!is_null($routematch)) {
                    break;
                }
            }
        }

        return $routematch;
    }

    /**
     * Normalize a filter
     *
     * @todo maybe this method should be somewhere else
     *
     * This method makes sure every key-value exists
     * and is an array.
     *
     * @param array $_filter Filter
     * @return array         Normalized filter
     */
    public function normalizeFilter($_filter)
    {
        $keys = array('site', 'target', 'language');

        foreach($keys as $key) {
            if (!isset($_filter[$key])) {
                $filter[$key] = array();
            }
            else if (!is_array($_filter[$key])) {
                $filter[$key] = array($_filter[$key]);
            }
            else {
                $filter[$key] = $_filter[$key];
            }
        }

        return $filter;
    }

    /**
     * Simplify a filter
     *
     * @todo maybe this method should be somewhere else
     *
     * This method makes sure every key-value exists
     * and is either false or a string.
     *
     * @param array $_filter Filter
     * @return array         Simplified filter
     */
    public function simplifyFilter($_filter)
    {
        $keys = array('site', 'target', 'language');

        foreach($keys as $key) {
            if (!isset($_filter[$key])) {
                $filter[$key] = false;
            }
            else if (is_array($_filter[$key])) {
                if (count($_filter[$key]) > 0) {
                    $filter[$key] = $_filter[$key][0];
                }
            }
            else {
                $filter[$key] = $_filter[$key];
            }
        }

        return $filter;
    }
}
