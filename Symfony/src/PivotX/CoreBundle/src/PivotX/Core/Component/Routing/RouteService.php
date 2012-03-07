<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use PivotX\Core\Component\Referencer\Reference;

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

    private $targets;
    private $sites;
    private $languages;

    private $routesetup;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        $this->logger->debug('service has started');

        $this->load();
    }

    public function load()
    {
        // @todo this is really wrong
        $config = Yaml::parse('/home/marcel/public_html/px4b/Symfony/app/config/pivotxrouting.yml');

        $this->processArrayConfig($config);
        /*
{ targets: [{ name: desktop, description: 'Desktop or tablet' }, { name: mobile, description: Mobile }], sites: [{ name: main, description: 'Main site' }], languages: [{ name: nl, description: Dutch, locale: nl_NL.utf-8 }, { name: en, description: English, locale: en_GB.utf-8 }], routeprefixes: [{ prefix: 'http://pivotx.com/', language: en, site: desktop, target: false, aliases: ['http://www.pivotx.com/', 'http://www.pivotx.eu/'] }, { prefix: 'http://pivotx.nl/', language: nl, site: desktop, target: false, aliases: ['http://www.pivotx.nl/'] }] } 
        */
    }

    private function processArrayConfig($config)
    {
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

            $this->targets[] = new Target($targeta['name'],$targeta['description']);
        }
        foreach($config['sites'] as $sitea) {
            if (!isset($sitea['name']) || !isset($sitea['description'])) {
                // @todo throw exception
                return;
            }

            $this->sites[] = new Site($sitea['name'],$sitea['description']);
        }
        foreach($config['languages'] as $languagea) {
            if (!isset($languagea['name']) || !isset($languagea['description']) || !isset($languagea['locale'])) {
                // @todo throw exception
                return;
            }

            $this->languages[] = new Language($languagea['name'],$languagea['description'],$languagea['locale']);
        }


        $this->routesetup = new RouteSetup();

        $this->routeprefixes = new RoutePrefixes($this->routesetup);
        foreach($config['routeprefixes'] as $routeprefixa) {
            if (!isset($routeprefixa['target']) || !isset($routeprefixa['site']) || !isset($routeprefixa['language'])) {
                // @todo throw exception
                return;
            }
            if (!isset($routeprefixa['prefix'])) {
                // @todo throw exception
                return;
            }
            $this->logger->debug('aliases',$routeprefixa['aliases']);
            $filter      = array ( 'target' => $routeprefixa['target'], 'site' => $routeprefixa['site'], 'language' => $routeprefixa['language'] );
            $routeprefix = new RoutePrefix($routeprefixa['prefix'],$routeprefixa['aliases']);

            $this->routeprefixes->add($filter,$routeprefix);
        }

        $this->routecollection = new RouteCollection($this->routesetup);
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

                if (isset($defaults['_rewrite'])) {
                    $defaults['_rewrite'] = new Reference(null,$defaults['_rewrite']);
                }
                if (isset($defaults['_redirect'])) {
                    $defaults['_redirect'] = new Reference(null,$defaults['_redirect']);
                }
            }
            $route = new Route(
                $routea['pattern'], $routea['public'],
                $requirements,
                $defaults
            );

            $this->routecollection->add(
                $routea['filter'],
                $route
            );
        }

        $this->logger->debug('pivotxrouting configuration read');
    }

    public function getRouteSetup()
    {
        return $this->routesetup;
    }
}
