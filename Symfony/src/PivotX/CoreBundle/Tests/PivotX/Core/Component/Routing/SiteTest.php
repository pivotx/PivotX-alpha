<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Core\Component\Routing\Site;

/**
 * Test various language settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $site = new Site('main','Main site');

        $this->assertNotNull($site);
    }
}
