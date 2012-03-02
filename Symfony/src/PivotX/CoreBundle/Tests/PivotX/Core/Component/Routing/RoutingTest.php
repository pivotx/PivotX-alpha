<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Core\Component\Routing\RouteSetup;
use PivotX\Core\Component\Routing\RoutePrefixes;
use PivotX\Core\Component\Routing\RouteCollection;
use PivotX\Core\Component\Routing\RoutePrefix;
use PivotX\Core\Component\Routing\Route;
use PivotX\Core\Component\Referencer\Reference;

/**
 * Test various route settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class RoutingTest extends \PHPUnit_Framework_TestCase
{
    public function testAdding()
    {
        $routesetup = new RouteSetup();

        $routeprefixes = new RoutePrefixes($routesetup);
        $routeprefixes
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                new RoutePrefix('http://pivotx.com/', array('http://www.pivotx.com/'))
                )
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                new RoutePrefix('http://pivotx.nl/', array('http://www.pivotx.nl/'))
                )
            ;

        $routecollection = new RouteCollection($routesetup);
        $routecollection
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    '_page/latest-news', 'latest-news',
                    array(),
                    array('rewrite' => new Reference(null,'(en)@archive/'.date('Y-m')))
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    '_page/latest-news', 'laatste-nieuws',
                    array(),
                    array('rewrite' => new Reference(null,'(nl)@archive/'.date('Y-m')))
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'archive/{yearmonth}', 'archive/{yearmonth}',
                    array('{yearmonth}' => '[0-9]{4}-[0-9]{2}'),
                    array('controller' => 'PivotXFrontend:Controller:showArchive' )
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'archive/{yearmonth}', 'archief/{yearmonth}',
                    array('{yearmonth}' => '[0-9]{4}-[0-9]{2}'),
                    array('controller' => 'PivotXFrontend:Controller:showArchive' )
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'entry/{id}', 'newsitem/{publicid}',
                    array('{publicid}' => '[a-z0-9-]+', '{id}' => '([0-9]+|[a-z0-9-]+)'),
                    array('controller' => 'PivotXFrontend:Controller:showEntity')
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'entry/{id}', 'nieuwsbericht/{publicid}',
                    array('{publicid}' => '[a-z0-9-]+', '{id}' => '([0-9]+|[a-z0-9-]+)'),
                    array('controller' => 'PivotXFrontend:Controller:showEntity')
                ))
            ;

        $this->assertNotNull($routematch = $routesetup->matchUrl('http://pivotx.com/latest-news'));

        $this->assertNull($routematch = $routesetup->matchUrl('http://pivotx.com/newsitem/{publicid}'));
        $this->assertNotNull($routematch = $routesetup->matchUrl('http://pivotx.com/newsitem/this-is-all-about-the-kittens'));
        $this->assertNotNull($routematch = $routesetup->matchUrl('http://pivotx.nl/nieuwsbericht/allemaal-over-de-poesjes'));
        $this->assertNotNull($routematch = $routesetup->matchUrl('http://pivotx.nl/archief/2012-01'));
        var_dump($routematch);
    }
}
