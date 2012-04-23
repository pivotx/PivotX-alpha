<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Component\Routing\Route;
use PivotX\Component\Routing\RouteMatch;

/**
 * Test various route settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class RouteMatchTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $route = new Route('page','about');

        $routematch = new RouteMatch($route);
        $this->assertNull($routematch->getRoutePrefix());

        $arguments = array(
            'a' => 'value a'
        );
        $routematch->setArguments($arguments);

        $args = $routematch->getArguments();
        $this->assertInternalType('array',$args);
        $this->assertArrayHasKey('a',$args);
    }

    /**
     * @expectedException PivotX\Component\Routing\Exception\RouteErrorHttpException
     */
    public function testMissingPrefixWhenBuildingUrl()
    {
        $route = new Route('page','about');

        $routematch = new RouteMatch($route);

        $this->assertNull($routematch->buildUrl());
    }
}
