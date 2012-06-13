<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Formats;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use PivotX\Component\Referencer\Reference;

/**
 * PivotX Formats Service
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service
{
    private $logger;

    /**
     * Registered formats
     */
    private $formats;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger  = $logger;
        $this->formats = array();


        // @todo remove this when we have another solution
        // inject ourselves and the logger into the Formats component
        \PivotX\Component\Formats\Formats::setServices($this, $logger);

        //echo "loaded formats service\n";
    }

    public function registerFormat(FormatInterface $format)
    {
        $this->formats[] = $format;
    }

    /**
     * Find a specific view
     *
     * @param string $name   name of the view
     * @return ViewInterface view if found, otherwise null
     */
    public function findFormat($name)
    {
        foreach($this->formats as $format) {
            if ($format->getName() == $name) {
                return $format;
            }
        }

        return null;
    }

    public function getRegisteredFormats()
    {
        return $this->formats;
    }
}
