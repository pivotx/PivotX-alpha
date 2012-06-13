<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 *
 * @todo add tests for the anchor reference to URL
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Component\Routing\RouteSetup;
use PivotX\Component\Routing\Language;
use PivotX\Component\Routing\RoutePrefixes;
use PivotX\Component\Routing\RouteCollection;
use PivotX\Component\Routing\RoutePrefix;
use PivotX\Component\Routing\Route;
use PivotX\Component\Referencer\Reference;

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

        $this->routesetup->addLanguage(new Language('en','English','en_GB.utf-8'));
        $this->routesetup->addLanguage(new Language('nl','Dutch','nl_NL.utf-8'));

        $routeprefixes = new RoutePrefixes($this->routesetup);
        $routeprefixes
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => 'desktop' ),
                new RoutePrefix('http://pivotx.com/', array('http://www.pivotx.com/'))
                )
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => 'desktop' ),
                new RoutePrefix('http://pivotx.nl/', array('http://www.pivotx.nl/'))
                )
            ;

        $routecollection = new RouteCollection($this->routesetup);
        $routecollection
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                $route = new Route(
                    '_page/frontpage', '',
                    array(),
                    array('_template' => 'frontpage.html.twig')
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    '_page/latest-news', 'latest-news',
                    array(),
                    array('_rewrite' => '(site=main&target=desktop&language=en)@archive/'.date('Y-m'))
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    '_page/latest-news', 'laatste-nieuws',
                    array(),
                    array('_rewrite' => '(site=main&target=desktop&language=nl)@archive/'.date('Y-m'))
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    'archive/{yearmonth}', 'archive/{yearmonth}',
                    array('yearmonth' => '[0-9]{4}-[0-9]{2}'),
                    array('_controller' => 'PivotXFrontend:Controller:showArchive' )
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    'archive/{yearmonth}', 'archief/{yearmonth}',
                    array('yearmonth' => '[0-9]{4}-[0-9]{2}'),
                    array('_controller' => 'PivotXFrontend:Controller:showArchive' )
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    'entry/{id}', 'newsitem/{publicid}',
                    array('publicid' => '[a-z0-9-]+', 'id' => '([0-9]+|[a-z0-9-]+)'),
                    array('_controller' => 'PivotXFrontend:Controller:showEntity')
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    'entry/{id}', 'nieuwsbericht/{publicid}',
                    array('publicid' => '[a-z0-9-]+', 'id' => '([0-9]+|[a-z0-9-]+)'),
                    array('_controller' => 'PivotXCore:DebugController:showEntity')
                ))

            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    'entry/{id}', 'old-site-link/{publicid}',
                    array('publicid' => '[a-z0-9-]+', 'id' => '([0-9]+|[a-z0-9-]+)'),
                    array('_controller' => 'PivotXFrontend:Controller:showEntity')
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => 'desktop' ),
                $route = new Route(
                    '_page/to-internal-invalid', 'to-internal-invalid',
                    array(),
                    array('_rewrite' => '(site=main&target=desktop&language=en)@false-internal-route')
                ))
            ;
    }

    public function tearDown()
    {
        unset($this->routesetup);
        $this->routesetup = null;
    }

    public function testRouteMatch()
    {
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.com/latest-news'));

        $attributes = $routematch->getAttributes();
        $this->assertInternalType('array',$attributes);
        $this->assertArrayHasKey('_site',$attributes);
        $this->assertEquals('main',$attributes['_site']);
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

    public function testUrlWithQueryToRoute()
    {
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.com/latest-news?order=reversed'));
    }

    public function testReferenceToUrl()
    {
        $reference = new Reference(null,'(site=main&language=nl)@archive/2012-01');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/archief/2012-01');

        $reference = new Reference(null,'(site=main&language=nl)@archive/'.date('Y-m'));
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/laatste-nieuws');

        $reference = new Reference(null,'(site=main&language=en)@_page/to-internal-invalid');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertNotEquals($routematch->buildUrl(),'http://pivotx.nl/to-internal-invalid');
    }

    public function testReferenceWithArgsToUrl()
    {
        $reference = new Reference(null,'(site=main&language=nl)@archive/2012-01?page=2');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/archief/2012-01?page=2');

        $reference = new Reference(null,'(site=main&language=nl)@archive/'.date('Y-m').'?page=2');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/laatste-nieuws?page=2');

        $reference = new Reference(null,'(site=main&language=en)@_page/to-internal-invalid');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference));
        $this->assertNotEquals($routematch->buildUrl(),'http://pivotx.nl/to-internal-invalid');
    }

    public function testReferenceQueryToUrl()
    {
        $reference = new Reference(null,'(site=main&language=nl)@archive/'.date('Y-m').'?queryargs');
        $this->assertNotNull($routematch = $this->routesetup->matchReference($reference,true));
        $this->assertEquals($routematch->buildUrl(),'http://pivotx.nl/laatste-nieuws?queryargs');
    }

    public function testFrontpageUrl()
    {
        $this->assertNotNull($routematch = $this->routesetup->matchUrl('http://pivotx.com/'));
    }
}
