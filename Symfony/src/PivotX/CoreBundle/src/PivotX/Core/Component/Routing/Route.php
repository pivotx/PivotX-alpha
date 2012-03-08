<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

use PivotX\Core\Component\Referencer\Reference;

/**
 * Route describes a PivotX route.
 *
 * A Route consists of the following elements:
 * - entity/filter     The entity/filter of the route (including macros/requirements)
 * - url               The public url of the route (including macros/requirements)
 * - requirements      The macros/requirements
 * - defaults          Defaults for this Route
 *   - _rewrite        - do an internal rewrite of this Route to another Reference
 *   - _rewrite_reference_text
 *                     - the textual version of the 'rewrite' reference
 *   - _redirect       - do an external redirect of this Route to another Reference
 *   - _controller     - the Symfony-style controller
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
     * Entity filter
     */
    private $efilter = false;

    /**
     * Entity filter pattern
     */
    private $efilter_pattern = false;

    /**
     * If the rntity filter pattern compiled
     */
    private $efilter_compiled = false;

    /**
     * Public url
     */
    private $url = false;

    /**
     * Public url as regex pattern
     */
    private $url_pattern = false;

    /**
     * If the pattern has been compiled
     */
    private $url_compiled = false;

    /**
     * Set the requirements
     */
    private $requirements = array();

    /**
     * Set the defaults
     */
    private $defaults = array();

    /**
     * Route filter
     */
    private $filter = false;

    /**
     * Constructor.
     *
     * @param string $name          name of the target
     * @param string $description   friendly description
     */
    public function __construct($entity_filter, $url, array $requirements = array(), array $defaults = array())
    {
        $this->setEntityAndFilter($entity_filter);
        $this->setUrl($url);
        $this->setRequirements($requirements);
        $this->setDefaults($defaults);
    }

    /**
     * Set entity and filter
     *
     * This method implements a fluent interface.
     *
     * @param string $entity_filter The entity and filter
     */
    public function setEntityAndFilter($entity_filter)
    {
        if (strpos($entity_filter,'/') === false) {
            $entity = $entity_filter;
            $filter = false;
        }
        else {
            list($entity,$filter) = explode('/',$entity_filter,2);
        }

        $this->entity  = $entity;
        $this->efilter = $filter;

        $this->efilter_compiled = false;

        return $this;
    }

    /**
     * Get the entity
     *
     * @return string entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Get the filter
     *
     * @return mixed filter or false if none defined
     */
    public function getEntityFilter()
    {
        return $this->efilter;
    }

    /**
     * Set the url
     *
     * This method implements a fluent interface.
     *
     * @param string $url The url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        $this->url_compiled = false;

        return $this;
    }

    /**
     * Compile this entity filter to a regex pattern
     *
     * This method implements a fluent interface.
     */
    public function compileEFilter()
    {
        $reqs = array();
        foreach($this->requirements as $k => $v) {
            $reqs['{'.$k.'}'] = '(?P<' . $k . '>' . $v . ')';
        }

        $efilter_pattern = strtr($this->efilter,$reqs);

        if ($efilter_pattern != $this->efilter) {
            // @todo can't always be '#'
            $this->efilter_pattern = '#^' . $efilter_pattern . '$#';
        }

        $this->efilter_compiled = true;

        return $this;
    }

    /**
     * Compile this URL to a regex pattern
     *
     * This method implements a fluent interface.
     */
    public function compileUrl()
    {
        $reqs = array();
        foreach($this->requirements as $k => $v) {
            $reqs['{'.$k.'}'] = '(?P<' . $k . '>' . $v . ')';
        }

        $url_pattern = strtr($this->url,$reqs);

        if ($url_pattern != $this->url) {
            // @todo can't always be '#'
            $this->url_pattern = '#^' . $url_pattern . '$#';
        }

        $this->url_compiled = true;

        return $this;
    }

    /**
     * Set requirements
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     */
    public function setRequirements(array $requirements = array())
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * Set defaults
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     */
    public function setDefaults(array $defaults = array())
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Get defaults
     *
     * @return array The defaults
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Set the filter
     *
     * This method implements a fluent interface.
     *
     * @param array $filter The filter
     */
    public function setFilter(array $filter = array())
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get the filter
     *
     * @return array The filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Try to match a filter to this prefix
     *
     * Filter to match is always a simplified filter.
     *
     * @param array $filter  Simplified filter to match against
     */
    public function matchFilter(array $filter)
    {
        $keys = array('site', 'target', 'language');

        foreach($keys as $key) {
            if ($filter[$key] !== false) {
                if (!in_array($filter[$key],$this->filter[$key])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Match URL
     *
     * @param array $filter File to match
     * @param string $url   URL to match
     * @return array        array with matching arguments if matched, false if not matched
     */
    public function matchUrl($filter, $url)
    {
        if ($this->url_compiled === false) {
            $this->compileUrl();
        }

        if ($this->matchFilter($filter)) {
            if ($this->url_pattern !== false) {
                //echo 'pattern['.$this->url_pattern.']'."\n";
                if (preg_match($this->url_pattern,$url,$matches)) {
                    // @todo swap requirements and defaults, Symfony-style
                    $arguments = array();
                    foreach($this->requirements as $k => $v) {
                        if (isset($matches[$k])) {
                            $arguments[$k] = $matches[$k];
                        }
                    }
                    foreach($this->defaults as $k => $v) {
                        if (!isset($arguments[$k])) {
                            $arguments[$k] = $v;
                        }
                    }
                    if (isset($arguments['_conversion'])) {
                        $new_args = call_user_func($arguments['_conversion'],$arguments,false);
                        $arguments = array_merge($arguments,$new_args);
                    }
                    return new RouteMatch($this,$arguments);
                }
            }
            else if ($this->url == $url) {
                return new RouteMatch($this);
            }
        }

        return false;
    }

    /**
     * Match Reference
     *
     * @param array $filter           Filter to match
     * @param Reference $reference    Reference to match
     * @param boolean $check_rewrites if true also allows rewrites to match (used for URL building), false don't
     * @return RouteMatch             A RouteMatch object or null if not matched
     */
    public function matchReference($filter, Reference $reference, $check_rewrites = false)
    {
        if ($this->efilter_compiled === false) {
            $this->compileEFilter();
        }

        $efilter = $reference->getFilter();

        if ($this->matchFilter($filter)) {
            if ($this->entity == $reference->getEntity()) {
                if ($this->efilter_pattern !== false) {
                    // echo 'pattern['.$this->efilter_pattern.']'." - ".$efilter."\n";
                    if (preg_match($this->efilter_pattern,$efilter,$matches)) {
                        $arguments = array();
                        foreach($this->requirements as $k => $v) {
                            if (isset($matches[$k])) {
                                $arguments[$k] = $matches[$k];
                            }
                        }
                        foreach($this->defaults as $k => $v) {
                            if (!isset($arguments[$k])) {
                                $arguments[$k] = $v;
                            }
                        }
                        if (isset($arguments['_conversion'])) {
                            $new_args = call_user_func($arguments['_conversion'],$arguments,true);
                            $arguments = array_merge($arguments,$new_args);
                        }
                        return new RouteMatch($this,$arguments);
                    }
                }
                else if ($this->efilter == $efilter) {
                    return new RouteMatch($this);
                }
            }
        }
        
        if ($check_rewrites === true) {
            if (isset($this->defaults['_rewrite'])) {
                if ($reference->buildTextReference() === $this->defaults['_rewrite']) {
                    return new RouteMatch($this);
                }
            }
        }

        return null;
    }

    /**
     * Build the entity filter
     *
     * @param array $arguments Arguments for this route
     * @return string          Entity/filter that matches this route
     */
    public function buildEFilter(array $arguments)
    {
        $replacements = array();
        foreach($arguments as $k => $v) {
            $replacements['{'.$k.'}'] = $v;
        }

        $efilter = $this->efilter;
        $efilter = strtr($efilter,$replacements);

        return $efilter;
    }

    /**
     * Build the URL
     *
     * @param array $arguments Arguments for this route
     * @return string          Url that matches this route
     */
    public function buildUrl(array $arguments)
    {
        $replacements = array();
        foreach($arguments as $k => $v) {
            $replacements['{'.$k.'}'] = $v;
        }

        $url = $this->url;
        $url = strtr($url,$replacements);

        return $url;
    }

    /**
     * Check if the route is a rewrite
     */
    public function isRewrite()
    {
        return isset($this->defaults['_rewrite']);
    }

    /**
     * Get the rewrite reference
     *
     * @param Reference $parent_reference The parent reference
     * @return Reference                  The rewritten reference
     */
    public function getRewrite($parent_reference = null)
    {
        return new Reference($parent_reference,$this->defaults['_rewrite']);
    }

    /**
     * Check if the route is supposed to redirect
     *
     * @return boolean true if route is supposed to redirect, false if not
     */
    public function isRedirect()
    {
        foreach($this->defaults as $k => $v) {
            if (substr($k,0,9) == '_redirect') {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the redirect reference
     *
     * @param Reference $parent_reference           The parent reference
     * @return array(Reference $reference, $status) The reference to redirect to and the status to use
     */
    public function getRedirect(Reference $parent_reference = null)
    {
        $reference = false;
        $status    = 302;

        foreach($this->defaults as $k => $v) {
            if (substr($k,0,9) == '_redirect') {
                $_status = substr($k,9);
                switch ($_status) {
                    case '_permanent':
                        $status = 301;
                        break;
                    case '_found':
                        $status = 302;
                        break;
                    case '_seeother':
                        $status = 303;
                        break;
                    case '_temporary':
                        $status = 307;
                        break;
                }

                $reference = new Reference($parent_reference,$v);
                break;
            }
        }

        return array($reference,$status);
    }
}
