<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Webresourcer;

/**
 * A Webresource describe a set of resources that are bundled together.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Webresource
{
    private $identifier;
    private $version;
    private $dependencies;


    /**
     * Constructor.
     *
     * @param string $identifier    The identifier
     * @param string $version       The version provided
     * @param string $dependencies  Other identifier/versions which are required
     */
    public function __construct($identifier, $version, array $dependencies = array())
    {
        $this->setIdentifier($identifier);
        $this->setVersion($version);
        $this->setDependencies($dependencies);
    }

    /**
     * Set the identifier
     */
    public function setIdentifier($identifier)
    {
        $this->indentifier = $identifier;
    }

    /**
     * Set the version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Set the dependencies
     */
    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
    }
}
