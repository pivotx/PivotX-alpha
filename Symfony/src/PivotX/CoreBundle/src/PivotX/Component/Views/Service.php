<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Views;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use PivotX\Component\Referencer\Reference;

/**
 * PivotX Views Service
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service
{
    private $logger;

    /**
     * Registered views
     */
    private $views;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        $this->views  = array();


        // @todo remove this when we have another solution
        // inject ourselves and the logger into the Views component
        \PivotX\Component\Views\Views::setServices($this, $logger);
    }

    public function registerView(ViewInterface $view)
    {
        $this->views[] = $view;
    }

    /**
     * Find a specific view
     *
     * @param string $name   name of the view
     * @return ViewInterface view if found, otherwise null
     */
    public function findView($name)
    {
        foreach($this->views as $view) {
            if ($view->getName() == $name) {
                return $view;
            }
        }

        return null;
    }

    public function getRegisteredViews()
    {
        return $this->views;
    }
}
