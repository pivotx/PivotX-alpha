<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Component\Routing\RouteSetup;
use PivotX\Component\Routing\RoutePrefixes;
use PivotX\Component\Routing\RoutePrefix;

/**
 * Test various routeprefix settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class RoutePrefixesTest extends \PHPUnit_Framework_TestCase
{
    public function testAdding()
    {
        $routesetup = new RouteSetup();

        $routeprefixes = new RoutePrefixes($routesetup);

        $this->assertTrue($routeprefixes !== false);

        $routeprefixes
            ->add(
                array( 'language' => 'en', 'site' => 'main' ),
                new RoutePrefix('http://pivotx.com/', array('http://www.pivotx.com/'))
                )
            ;

        $routeprefixes
            ->add(
                array( 'language' => array('en', 'nl'), 'site' => array ( 'mobile' ) ),
                new RoutePrefix('http://m.pivotx.com/', array('http://www.pivotx.com/'))
                )
            ;

        $this->assertNotNull($routeprefix = $routeprefixes->matchUrl('http://pivotx.com/'));
        $this->assertEquals($routeprefix->getPrefix(),'http://pivotx.com/');

        $this->assertNotNull($routeprefix = $routeprefixes->matchUrl('http://www.pivotx.com/'));
        $this->assertEquals($routeprefix->getPrefix(),'http://pivotx.com/');
        $this->assertNotEquals($routeprefix->getPrefix(),'http://www.pivotx.com/');
        $this->assertTrue($routeprefix->isAlias('http://www.pivotx.com/'));
        $this->assertFalse($routeprefix->isAlias('https://www.pivotx.com/'));
        $this->assertCount(1,$routeprefix->getAliases());

        $filter = $routeprefix->getFilter();

        // we don't match incomplete url's
        $this->assertNull($routeprefix = $routeprefixes->matchUrl('http://pivotx.com'));


        $this->assertNotNull($routeprefix = $routeprefixes->matchUrl('http://pivotx.com/latest-news'));
        $this->assertEquals($routeprefix->getPrefix(),'http://pivotx.com/');

        $this->assertNull($routeprefixes->matchUrl('http://bbc.co.uk/'));


        $this->assertNull($routeprefix = $routeprefixes->matchFilter(array('language' => 'nl', 'site' => 'main')));
        $this->assertNotNull($routeprefix = $routeprefixes->matchFilter(array('language' => 'en', 'site' => 'main')));
        $this->assertNotNull($routeprefix = $routeprefixes->matchFilter(array('language' => array('en'), 'site' => 'main')));


        // mobile stuff

        $this->assertNotNull($routeprefix = $routeprefixes->matchUrl('http://m.pivotx.com/'));
        $filter = $routeprefix->getFilter();
    }

    // @todo add reference tests
}

