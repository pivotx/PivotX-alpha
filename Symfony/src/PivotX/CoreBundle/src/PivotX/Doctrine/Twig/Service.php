<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Doctrine\Twig;


/**
 * PivotX Doctrine Twig interface
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service extends \Twig_Extension
{
    protected $environment = false;

    /**
     */
    public function __construct()
    {
    }

    /**
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'pivotx.doctrine';
    }

    public function getFunctions()
    {
        return array(
        );
    }

    public function getTokenParsers()
    {
        return array(
        );
    }
}
