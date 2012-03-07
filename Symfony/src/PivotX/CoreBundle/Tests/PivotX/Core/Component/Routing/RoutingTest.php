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
    private $routesetup;

    public function setUp()
    {
        $this->routesetup = new RouteSetup();

        $routeprefixes = new RoutePrefixes($this->routesetup);
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

        $routecollection = new RouteCollection($this->routesetup);
        $routecollection
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    '_page/latest-news', 'latest-news',
                    array(),
                    array('_rewrite' => new Reference(null,'main/(en)@archive/'.date('Y-m')))
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    '_page/latest-news', 'laatste-nieuws',
                    array(),
                    array('_rewrite' => new Reference(null,'main/(nl)@archive/'.date('Y-m')))
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'archive/{yearmonth}', 'archive/{yearmonth}',
                    array('yearmonth' => '[0-9]{4}-[0-9]{2}'),
                    array('_controller' => 'PivotXFrontend:Controller:showArchive' )
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'archive/{yearmonth}', 'archief/{yearmonth}',
                    array('yearmonth' => '[0-9]{4}-[0-9]{2}'),
                    array('_controller' => 'PivotXFrontend:Controller:showArchive' )
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'entry/{id}', 'newsitem/{publicid}',
                    array('publicid' => '[a-z0-9-]+', 'id' => '([0-9]+|[a-z0-9-]+)'),
                    array('_controller' => 'PivotXFrontend:Controller:showEntity')
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'entry/{id}', 'nieuwsbericht/{publicid}',
                    array('publicid' => '[a-z0-9-]+', 'id' => '([0-9]+|[a-z0-9-]+)'),
                    array('_controller' => 'PivotXCore:DebugController:showEntity')
                ))

            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    'entry/{id}', 'old-site-link/{publicid}',
                    array('publicid' => '[a-z0-9-]+', 'id' => '([0-9]+|[a-z0-9-]+)'),
                    array('_controller' => 'PivotXFrontend:Controller:showEntity')
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    '_page/to-internal-invalid', 'to-internal-invalid',
                    array(),
                    array('_rewrite' => new Reference(null,'main/(en)@false-internal-route'))
                ))
            ;
    }

    public function tearDown()
    {
        unset($this->routesetup);
        $this->routesetup = null;
    }

    public function testUrlToRoute()
    {
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.com/latest-news'));

        $this->assertNull($routematch = $this->routesetup->matchUrl('http://pivotx.com/newsitem/{publicid}'));
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.com/newsitem/this-is-all-about-the-kittens'));
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.nl/nieuwsbericht/allemaal-over-de-poesjes'));
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.nl/archief/2012-01'));
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://www.pivotx.nl/archief/2012-01'));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/archief/2012-01');

        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://www.pivotx.com/latest-news'));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.com/latest-news');

        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://www.pivotx.com/archive/'.date('Y-m')));
        $reference = $routematch->buildReference(null);
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.com/latest-news');
    }

    public function testReferenceToUrl()
    {
        $reference = new Reference(null,'main/(nl)@archive/2012-01');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/archief/2012-01');

        $reference = new Reference(null,'main/(nl)@archive/'.date('Y-m'));
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/laatste-nieuws');

        $reference = new Reference(null,'main/(en)@_page/to-internal-invalid');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertNotEquals($routematch->buildUrl(),'http://pivotx.nl/to-internal-invalid');
    }
}
