<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

use PivotX\Core\Component\Referencer\Reference;

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
     * RouteSetup
     */
    private $routesetup = null;

    /**
     * RoutePrefix
     */
    private $routeprefix = null;

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
     * Set the routesetup
     *
     * This method implements a fluent interface.
     *
     * @param RouteSetup $routesetup The routesetup
     */
    public function setRouteSetup(RouteSetup $routesetup)
    {
        $this->routesetup = $routesetup;

        return $this;
    }

    /**
     * Set the routeprefix
     *
     * This method implements a fluent interface.
     *
     * @param RoutePrefix $routeprefix The routeprefix
     */
    public function setRoutePrefix(RoutePrefix $routeprefix)
    {
        $this->routeprefix = $routeprefix;

        return $this;
    }

    /**
     * Get the routeprefix
     *
     * @return RoutePrefix The routeprefix
     */
    public function getRoutePrefix()
    {
        return $this->routeprefix;
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

    /**
     * Get the arguments
     *
     * @return array The arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Get Symfony-style request attributes
     *
     * @return array Attributes
     */
    public function getAttributes()
    {
        $attributes = array();
        $attributes = array_merge($attributes,$this->route->getDefaults());
        $attributes = array_merge($attributes,$this->getArguments());

        $filter    = $this->routeprefix->getFilter();
        $languages = $this->routesetup->getLanguages();
        $language  = false;
        foreach($filter['language'] as $filter_language) {
            foreach($languages as $setup_language) {
                if ($setup_language->getName() == $filter_language) {
                    $language = $setup_language;
                    break;
                }
            }

            if ($language !== false) {
                break;
            }
        }

        if ($language !== false) {
            $attributes['_locale'] = $language->getLocale();
            var_dump($attributes);
        }

        $attributes['_routematch'] = $this;

        return $attributes;
    }

    /**
     * Build the Reference for this match
     *
     * Return the Reference for this match.
     *
     * @param Reference $relative if set to a Reference return the relative Reference, otherwise absolute
     * @return Reference          Build Reference
     */
    public function buildReference(Reference $relative = null)
    {
        $ref_array = array();

        $filter = $this->routeprefix->getFilter();

        $ref_array = array_merge($ref_array, $this->routesetup->simplifyFilter($filter));

        $ref_array['entity'] = $this->route->getEntity();
        $ref_array['filter'] = $this->route->buildEFilter($this->arguments);

        return new Reference($relative, $ref_array);
    }

    /**
     * Build the URL of this match
     *
     * Return the URL for this match.
     *
     * @param Reference $relative      if set to a Reference return the relative URL, otherwise absolute
     * @param boolean reevaluate_route if true, the best route/url is returned, if false it returns the matched route
     * @return string                  The build URL or null if there is no URL
     */
    public function buildUrl(Reference $relative = null, $reevaluate_route = true)
    {
        if (is_null($this->routeprefix)) {
            // @todo should we throw an exception here?
            return null;
        }

        if ($reevaluate_route) {
            $reference = $this->buildReference($relative);

            $routematch = $this->routesetup->matchReference($reference,true);
            if (!is_null($routematch)) {
                return $routematch->buildUrl($relative,false);
            }
        }

        $url  = $this->routeprefix->buildUrl();
        $url .= $this->route->buildUrl($this->arguments);

        return $url;
    }
}
