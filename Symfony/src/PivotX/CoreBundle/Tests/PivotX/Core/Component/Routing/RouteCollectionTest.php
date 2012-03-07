<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Core\Component\Routing\RouteSetup;
use PivotX\Core\Component\Routing\RouteCollection;
use PivotX\Core\Component\Routing\Route;
use PivotX\Core\Component\Referencer\Reference;

/**
 * Test various route settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class RouteCollectionTest extends \PHPUnit_Framework_TestCase
{
    private $routesetup;
    private $routecollection;

    public function setUp()
    {
        $this->routesetup = new RouteSetup();

        $this->routecollection = new RouteCollection($this->routesetup);

        $this->routecollection
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                new Route(
                    '_page/latest-news', 'latest-news',
                    array(),
                    array('_rewrite' => new Reference(null,'(en)@archive/'.date('Y-m')))
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                new Route(
                    '_page/latest-news', 'laatste-nieuws',
                    array(),
                    array('_rewrite' => new Reference(null,'(nl)@archive/'.date('Y-m')))
                ))

            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                new Route(
                    'archive/{yearmonth}', 'archive/{yearmonth}',
                    array('yearmonth' => '[0-9]{4}-[0-9]{2}'),
                    array('_controller' => 'PivotXFrontend:Controller:showArchive')
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                new Route(
                    'archive/{yearmonth}', 'archief/{yearmonth}',
                    array('yearmonth' => '[0-9]{4}-[0-9]{2}'),
                    array('_controller' => 'PivotXFrontend:Controller:showArchive')
                ))

            // URL 'belasting' should be redirect to either the English or Dutch site
            ->add(
                array( 'language' => 'en', 'site' => 'main', 'target' => false ),
                new Route(
                    '', 'belasting',
                    array(),
                    array('_redirect' => new Reference(null,'(en)@category/taxes'))
                ))
            ->add(
                array( 'language' => 'nl', 'site' => 'main', 'target' => false ),
                new Route(
                    '', 'belasting',
                    array(),
                    array('_redirect' => new Reference(null,'(nl)@category/taxes'))
                ))
            ;
    }

    public function tearDown()
    {
        unset($this->routecollection);
        $this->routecollection = null;

        unset($this->routesetup);
        $this->routesetup = null;
    }

    public function testUrlToRoute()
    {
        /*
        $filter = $route->getFilter();
        $this->assertEquals($filter,array('language'=>array('en'),'site'=>array('main'),'target'=>array()));
        */
    
        $filter = array('site' => 'main','language' => 'en', 'target' => false);
        $this->assertNotNull($routematch = $this->routecollection->matchUrl($filter,'latest-news'));
        $this->assertArrayHasKey('_rewrite',$routematch->getRoute()->getDefaults());
        $this->assertNull($routematch = $this->routecollection->matchUrl($filter,'not-found'));
        $this->assertNull($routematch = $this->routecollection->matchUrl($filter,'laatste-nieuws'));
        $this->assertNotNull($routematch = $this->routecollection->matchUrl($filter,'belasting'));

        $filter = array('site' => 'main','language' => 'nl', 'target' => false);
        $this->assertNotNull($routematch = $this->routecollection->matchUrl($filter,'laatste-nieuws'));
        $this->assertNull($routematch = $this->routecollection->matchUrl($filter,'latest-news'));
        $this->assertNotNull($routematch = $this->routecollection->matchUrl($filter,'belasting'));
        $this->assertArrayHasKey('_redirect',$routematch->getRoute()->getDefaults());

        $filter = array('site' => 'main','language' => 'nl', 'target' => false);
        $this->assertNotNull($routematch = $this->routecollection->matchUrl($filter,'laatste-nieuws'));
        $this->assertNull($routematch = $this->routecollection->matchUrl($filter,'latest-news'));
        $this->assertNotNull($routematch = $this->routecollection->matchUrl($filter,'belasting'));
        $this->assertArrayHasKey('_redirect',$routematch->getRoute()->getDefaults());

        $filter = array('site' => 'main','language' => 'en', 'target' => false);
        $this->assertNull($routematch = $this->routecollection->matchUrl($filter,'last-news'));
        $this->assertNull($routematch = $this->routecollection->matchUrl($filter,'archive/201201'));
    }

    public function testReferenceToRoute()
    {
        $this->assertNotNull($routematch = $this->routecollection->matchReference(new Reference(null,'main/(en)@_page/latest-news')));
        // @todo should test the value of routematch
        $this->assertNotNull($routematch = $this->routecollection->matchReference(new Reference(null,'main/(en)@archive/2012-01')));

        $this->assertNull($routematch = $this->routecollection->matchReference(new Reference(null,'main/(en)@_page/last-news')));
        $this->assertNull($routematch = $this->routecollection->matchReference(new Reference(null,'main/(en)@archive/201201')));
    }
}
