<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Routing;

/**
 * Target defines a browser rendering target.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Target
{
    /**
     * Name of the target
     */
    private $name = false;

    /**
     * Description of the target
     */
    private $description = false;

    /**
     * Constructor.
     *
     * @param string $name          name of the target
     * @param string $description   friendly description
     */
    public function __construct($name, $description = false)
    {
        $this->setName($name);
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
     * Get the name
     *
     * @return string The name
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * Get the description
     *
     * @return string The description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
