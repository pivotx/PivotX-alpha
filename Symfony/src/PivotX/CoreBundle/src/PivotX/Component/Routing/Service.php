<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Routing;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use PivotX\Component\Referencer\Reference;

/**
 * PivotX Routing Service
 *
 * @todo terrible implementation currently!
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service
{
    private $logger;

    private $routesetup;

    public function __construct(LoggerInterface $logger = null, $file = false)
    {
        $this->logger     = $logger;
        $this->routesetup = new RouteSetup();

        if ($file === false) {
            // @todo should be removed
            $fname = '/home/marcel/public_html/px4b/Symfony/app/config/pivotxrouting.yml';
            $this->load($fname);
        }
    }

    public function load($fname)
    {
        //echo "Loading Route Service..\n";
        $this->logger->info('Loading Route Service '.$fname);

        // @todo this is really wrong
        $config = Yaml::parse($fname);

        $this->processArrayConfig($config);
    }

    public function processTextConfig($text)
    {
        $config = Yaml::parse($text);

        $this->processArrayConfig($config);
    }

    private function processArrayConfig($config)
    {
        if (!isset($config['targets']) || !is_array($config['targets'])) {
            // @todo throw exception
            $this->logger->err('No targets defined in route configuration.');
            return;
        }
        if (!isset($config['sites']) || !is_array($config['sites'])) {
            // @todo throw exception
            $this->logger->err('No sites defined in route configuration.');
            return;
        }
        if (!isset($config['languages']) || !is_array($config['languages'])) {
            // @todo throw exception
            $this->logger->err('No languages defined in route configuration.');
            return;
        }

        foreach($config['targets'] as $targeta) {
            if (!isset($targeta['name']) || !isset($targeta['description'])) {
                // @todo throw exception
                $this->logger->err('No name and description defined for a target.');
                return;
            }

            $this->routesetup->addTarget(new Target($targeta['name'],$targeta['description']));
        }
        foreach($config['sites'] as $sitea) {
            if (!isset($sitea['name']) || !isset($sitea['description'])) {
                // @todo throw exception
                $this->logger->err('No name and description defined for a site.');
                return;
            }

            $this->routesetup->addSite(new Site($sitea['name'],$sitea['description']));
        }
        foreach($config['languages'] as $languagea) {
            if (!isset($languagea['name']) || !isset($languagea['description']) || !isset($languagea['locale'])) {
                // @todo throw exception
                $this->logger->err('No name, description and locale defined for a language.');
                return;
            }

            $this->routesetup->addLanguage(new Language($languagea['name'],$languagea['description'],$languagea['locale']));
        }

        $routeprefixes = new RoutePrefixes($this->routesetup);
        foreach($config['routeprefixes'] as $routeprefixa) {
            if (!isset($routeprefixa['filter']) || !isset($routeprefixa['filter']['target']) || !isset($routeprefixa['filter']['site']) || !isset($routeprefixa['filter']['language'])) {
                // @todo throw exception
                $this->logger->err('Missing target, site or language for routeprefix/filter.');
                return;
            }
            if (!isset($routeprefixa['prefix'])) {
                // @todo throw exception
                $this->logger->err('Missing prefix for routeprefix.');
                return;
            }
            $filter      = array ( 'target' => $routeprefixa['filter']['target'], 'site' => $routeprefixa['filter']['site'], 'language' => $routeprefixa['filter']['language'] );
            $aliases     = array();
            if (isset($routeprefixa['aliases'])) {
                $aliases = $routeprefixa['aliases'];
                if (!is_array($aliases)) {
                    $aliases = array($aliases);
                }
            }
            $routeprefix = new RoutePrefix($routeprefixa['prefix'],$aliases);

            $routeprefixes->add($filter,$routeprefix);
        }

        $routecollection = new RouteCollection($this->routesetup);
        foreach($config['routes'] as $routea) {
            if (!isset($routea['filter']) || !isset($routea['filter']['target']) || !isset($routea['filter']['site']) || !isset($routea['filter']['language'])) {
                // @todo throw exception
                $this->logger->err('Missing target, site and language for route.');
                return;
            }
            if (!isset($routea['pattern']) || !isset($routea['public'])) {
                // @todo throw exception
                $this->logger->err('Missing pattern and public for route.');
                return;
            }
            $requirements = array();
            $defaults     = array();
            if (isset($routea['requirements']) && is_array($routea['requirements'])) {
                $requirements = $routea['requirements'];
            }
            if (isset($routea['defaults']) && is_array($routea['defaults'])) {
                $defaults = $routea['defaults'];
            }
            $route = new Route(
                $routea['pattern'], $routea['public'],
                $requirements,
                $defaults
            );

            $routecollection->add(
                $routea['filter'],
                $route
            );
        }
    }

    public function getRouteSetup()
    {
        return $this->routesetup;
    }
}
