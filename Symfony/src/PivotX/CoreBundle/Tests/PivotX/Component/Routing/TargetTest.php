<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Component\Routing\Target;

/**
 * Test various language settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class TargetTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $target = new Target('desktop','Regular version');

        //$this->assertEquals($target->getName(),'desktop');
        //$this->assertEquals($target->getDescription(),'Regular version');
    }
}
