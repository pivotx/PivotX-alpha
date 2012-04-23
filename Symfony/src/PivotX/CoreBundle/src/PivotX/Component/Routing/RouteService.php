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
class RouteService
{
    private $logger;

    private $routesetup;

    public function __construct(LoggerInterface $logger = null, $file = false)
    {
        $this->logger = $logger;

        if ($file === false) {
            $this->load();
        }
    }

    public function load()
    {
        // @todo this is really wrong
        $config = Yaml::parse('/home/marcel/public_html/px4b/Symfony/app/config/pivotxrouting.yml');

        $this->processArrayConfig($config);
    }

    public function processTextConfig($text)
    {
        $config = Yaml::parse($text);

        $this->processArrayConfig($config);
    }

    private function processArrayConfig($config)
    {
        $routesetup = new RouteSetup();

        if (!isset($config['targets']) || !is_array($config['targets'])) {
            // @todo throw exception
            return;
        }
        if (!isset($config['sites']) || !is_array($config['sites'])) {
            // @todo throw exception
            return;
        }
        if (!isset($config['languages']) || !is_array($config['languages'])) {
            // @todo throw exception
            return;
        }

        foreach($config['targets'] as $targeta) {
            if (!isset($targeta['name']) || !isset($targeta['description'])) {
                // @todo throw exception
                return;
            }

            $routesetup->addTarget(new Target($targeta['name'],$targeta['description']));
        }
        foreach($config['sites'] as $sitea) {
            if (!isset($sitea['name']) || !isset($sitea['description'])) {
                // @todo throw exception
                return;
            }

            $routesetup->addSite(new Site($sitea['name'],$sitea['description']));
        }
        foreach($config['languages'] as $languagea) {
            if (!isset($languagea['name']) || !isset($languagea['description']) || !isset($languagea['locale'])) {
                // @todo throw exception
                return;
            }

            $routesetup->addLanguage(new Language($languagea['name'],$languagea['description'],$languagea['locale']));
        }

        $routeprefixes = new RoutePrefixes($routesetup);
        foreach($config['routeprefixes'] as $routeprefixa) {
            if (!isset($routeprefixa['filter']) || !isset($routeprefixa['filter']['target']) || !isset($routeprefixa['filter']['site']) || !isset($routeprefixa['filter']['language'])) {
                // @todo throw exception
                return;
            }
            if (!isset($routeprefixa['prefix'])) {
                // @todo throw exception
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

        $routecollection = new RouteCollection($routesetup);
        foreach($config['routes'] as $routea) {
            if (!isset($routea['filter']) || !isset($routea['filter']['target']) || !isset($routea['filter']['site']) || !isset($routea['filter']['language'])) {
                // @todo throw exception
                return;
            }
            if (!isset($routea['pattern']) || !isset($routea['public'])) {
                // @todo throw exception
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

        $this->routesetup = $routesetup;
    }

    public function getRouteSetup()
    {
        return $this->routesetup;
    }
}
