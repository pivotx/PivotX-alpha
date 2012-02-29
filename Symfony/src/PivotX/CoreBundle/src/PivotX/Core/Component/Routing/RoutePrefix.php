<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

/**
 * RoutePrefix is a base url, used for the highest level of routing
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class RoutePrefix
{
    /**
     * Prefix
     */
    private $prefix = false;

    /**
     * Aliases
     */
    private $aliases = array();

    /**
     * Constructor.
     *
     * @param string $name    canonical prefix
     * @param array  $aliases other prefixes
     */
    public function __construct($prefix, array $aliases = array())
    {
        $this->setPrefix($prefix);
        $this->setAliases($aliases);
    }

    /**
     * Set the prefix
     *
     * This method implements a fluent interface.
     *
     * @param string $prefix The prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set aliases
     *
     * This method implements a fluent interface.
     *
     * @param array $aliases The aliases
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;

        return $this;
    }
}
