<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Routing;

/**
 * Language defines rendering language.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Language
{
    /**
     * Name of the language
     */
    private $name = false;

    /**
     * Description of the language
     */
    private $description = false;

    /**
     * Locale
     */
    private $locale = false;

    /**
     * Constructor.
     *
     * @param string $name        name of the target
     * @param string $locale      locale to set
     * @param string $description friendly description
     */
    public function __construct($name, $description = false, $locale = false)
    {
        $this->setName($name);
        if ($description !== false) {
            $this->setDescription($description);
        }
        if ($locale !== false) {
            $this->setLocale($locale);
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
     * Set the locale
     *
     * This method implements a fluent interface.
     *
     * @param string $name The name
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale
     *
     * @return string The locale
     */
    public function getLocale()
    {
        return $this->locale;
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

