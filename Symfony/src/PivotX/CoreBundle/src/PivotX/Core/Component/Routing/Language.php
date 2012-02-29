<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * @todo somehow this also should be allowed to have it's own hostname
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

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
    public function __construct($name, $locale, $description = false)
    {
        $this->setName($name);
        $this->setLocale($locale);
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

