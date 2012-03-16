<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

use PivotX\Core\Component\Referencer\Reference;

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
     * All the targets
     */
    private $targets = array();

    /**
     * All the sites
     */
    private $sites = array();

    /**
     * All the languages
     */
    private $languages = array();

    /**
     * All the routeprefixeses
     */
    private $routeprefixeses = array();

    /**
     * All the routecollections
     */
    private $routecollections = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Add target
     *
     * This method implements a fluent interface.
     *
     * @param Target $target Target to add
     */
    public function addTarget(Target $target)
    {
        $this->targets[] = $target;

        return $this;
    }

    /**
     * Get targets
     *
     * @return array Array of targets
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Add site
     *
     * This method implements a fluent interface.
     *
     * @param Site $site Site to add
     */
    public function addSite(Site $site)
    {
        $this->sites[] = $site;

        return $this;
    }

    /**
     * Add language
     *
     * This method implements a fluent interface.
     *
     * @param Language $language Language to add
     */
    public function addLanguage(Language $language)
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Get languages
     *
     * @return array Array of languages
     */
    public function getLanguages()
    {
        return $this->languages;
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
     * Find the best RoutePrefix for a filter
     *
     * @param array $filter Filter to find.
     * @return RoutePrefix  Best RoutePrefix or null if none
     */
    public function findRoutePrefixOnFilter(array $filter)
    {
        foreach($this->routeprefixeses as $routeprefixes) {
            $routeprefix = $routeprefixes->matchFilter($filter);
            if (!is_null($routeprefix)) {
                return $routeprefix;
            }
        }

        return null;
    }

    /**
     * Search for a Reference
     *
     * @todo brute-force method used now, should be optimised
     *
     * @param Reference $reference    Reference to search for
     * @param boolean $check_rewrites if true also allows rewrites to match (used for URL building), false don't
     * @return RouteMatch RouteMatch  if found, otherwise null
     */
    public function matchReference(Reference $reference, $check_rewrites = false)
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
            $filter = $routeprefix->getFilter();

            foreach($this->routecollections as $routecollection) {
                $routematch = $routecollection->matchReference($reference, $check_rewrites);
                if (!is_null($routematch)) {
                    $routematch->setRouteSetup($this);
                    $routematch->setRoutePrefix($routeprefix);
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
        $route_url   = false;

        foreach($this->routeprefixeses as $routeprefixes) {
            $routeprefix = $routeprefixes->matchUrl($url);
            if (!is_null($routeprefix)) {
                $route_url = $routeprefix->getRouteUrl($url);
                break;
            }
        }


        if (!is_null($routeprefix)) {
            $filter    = $routeprefix->getFilter();

            foreach($this->routecollections as $routecollection) {
                $routematch = $routecollection->matchUrl($filter,$route_url);
                if (!is_null($routematch)) {
                    $routematch->setRouteSetup($this);
                    $routematch->setRoutePrefix($routeprefix);
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
            else if ((!is_array($_filter[$key]) && $_filter[$key] === false)) {
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
