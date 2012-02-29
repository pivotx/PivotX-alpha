<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * @todo maybe a language could also change hostnames
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

/**
 * Site defines a specific site.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Site
{
    /**
     * Name of the site
     */
    private $name = false;

    /**
     * Description of the site
     */
    private $description = false;

    /**
     * Canonical host
     */
    private $canonical_hostname = false;

    /**
     * Hostnames
     */
    private $hostnames = array();

    /**
     * Constructor.
     *
     * @param string $name               name of the target
     * @param string $canonical_hostname canonical hostname
     * @param array  $hostnames          other hostnames to respond to
     * @param string $description        friendly description
     */
    public function __construct($name, $canonical_host, array $hostnames = array(), $description = false)
    {
        $this->setName($name);
        $this->setCanonicalHostname($canonical_hostname);
        $this->setHostnames($hostnames);
        if ($description !== false) {
            $this->setDescription($description);
        }
    }

    /**
     * Set the name
     *
     * This method implements a fluent interface.
     *
     * @param string $name The name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the canonical hostname
     *
     * This method implements a fluent interface.
     *
     * @param string $hostname The hostname
     */
    public function setCanonicalHostname($hostname)
    {
        $this->canonical_hostname = $hostname;

        return $this;
    }

    /**
     * Set the other hostnames
     *
     * This method implements a fluent interface.
     *
     * @param array $hostnames The other hostnames
     */
    public function setHostnames($hostnames)
    {
        $this->hostnames = $hostnames;

        return $this;
    }

    /**
     * Set the description
     *
     * This method implements a fluent interface.
     *
     * @param string $description The description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}


