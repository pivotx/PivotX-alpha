<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Core\Component\Routing\Route;

/**
 * Test various route settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $route = new Route('about','about');
        $this->assertEquals($route->getEntity(),'about');
        $this->assertFalse($route->getEntityFilter());
        
        $route = new Route('page/about','about');
        $this->assertEquals($route->getEntity(),'page');
        $this->assertEquals($route->getEntityFilter(),'about');
    }
}
