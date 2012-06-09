<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Routing;

use PivotX\Component\Routing\Exception\RouteErrorHttpException;
use PivotX\Component\Referencer\Reference;

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
        foreach($languages as $setup_language) {
            if ($setup_language->getName() == $filter['language']) {
                $language = $setup_language;
                break;
            }
        }

        if ($language !== false) {
            $attributes['_locale'] = $language->getLocale();
        }

        $attributes['_site']       = $filter['site'];
        $attributes['_target']     = $filter['target'];
        $attributes['_language']   = $filter['language'];
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

        if (isset($this->arguments['_query'])) {
            $ref_array['query']  = $this->arguments['_query'];
        }
        if (isset($this->arguments['_anchor_query'])) {
            $ref_array['anchor_query']  = $this->arguments['_anchor_query'];
        }

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
            // @todo should be better
            $message = sprintf('RouteMatch is missing a RoutePrefix');
            throw new RouteErrorHttpException($message);
        }

        if ($reevaluate_route) {
            $reference = $this->buildReference($relative);
            //echo '<pre>reference:'; var_dump($reference); echo '</pre>';

            $routematch = $this->routesetup->matchReference($reference, true);
            if (!is_null($routematch)) {
                return $routematch->buildUrl($relative, false);
            }
        }

        $url  = $this->routeprefix->buildUrl();
        $url .= $this->route->buildUrl($this->arguments);

        return $url;
    }

    /**
     * Check if the route is a rewrite
     *
     * @return boolean true if route is a rewrite, false if not
     */
    public function isRewrite()
    {
        return $this->route->isRewrite();
    }

    /**
     * Return the new RouteMatch
     *
     * @return RouteMatch The RouteMatch record of the rewrite, return null if no route is found
     */
    public function getRewrite()
    {
        $parent_reference = $this->buildReference(null);

        $reference = $this->route->getRewrite($parent_reference);

        $routematch = $this->routesetup->matchReference($reference,true);

        return $routematch;
    }

    /**
     * Check if the route is supposed to redirect
     *
     * @return boolean true if route is supposed to redirect, false if not
     */
    public function isRedirect()
    {
        return $this->route->isRedirect();
    }

    /**
     * Get the redirect reference
     *
     * @return array(RouteMatch $routematch, $status) The RouteMatch to redirect to and the status to use
     *                                                The $routematch is null if nothing matched
     */
    public function getRedirect()
    {
        $routematch = null;
        $status     = 302;

        $parent_reference = $this->buildReference(null);

        list($reference,$status) = $this->route->getRedirect($parent_reference);

        $routematch = $this->routesetup->matchReference($reference,true);

        return array($routematch,$status);
    }

    /**
     * Get all the language variants of this RouteMatch
     *
     * @return array($language_name=>$url) ALl the variants
     */
    public function getLanguageUrls()
    {
        $urls      = array();
        $reference = $this->buildReference(null);

        $languages = $this->routesetup->getLanguages();
        foreach($languages as $language) {
            $reference->setLanguage($language->getName());

            $routematch = $this->routesetup->matchReference($reference,true);

            if (!is_null($routematch)) {
                $urls[$language->getName()] = $routematch->buildUrl();
            }
        }

        return $urls;
    }

    /**
     * Get all the target variants of this RouteMatch
     *
     * @return array($target_name => $url) ALl the variants
     */
    public function getTargetUrls()
    {
        $urls      = array();
        $reference = $this->buildReference(null);

        $targets = $this->routesetup->getTargets();
        foreach($targets as $target) {
            $reference->setTarget($target->getName());

            $routematch = $this->routesetup->matchReference($reference,true);

            if (!is_null($routematch)) {
                $urls[$target->getName()] = $routematch->buildUrl();
            }
        }

        return $urls;
    }

    /**
     * Build another URL
     *
     * Used to easily create url's relative to the this RouteMatch
     *
     * @param mixed $link     Reference to link to, in string or associative array format
     * @param string $default Link to return when no match found
     * @return string         URL
     */
    public function buildOtherUrl($link, $default = null)
    {
        $reference = new \PivotX\Component\Referencer\Reference($this->buildReference(), $link);

        $routematch = $this->routesetup->matchReference($reference);

        if (!is_null($routematch)) {
            return $routematch->buildUrl();
        }

        if (!is_null($default)) {
            return $default;
        }

        return null;
    }
}
