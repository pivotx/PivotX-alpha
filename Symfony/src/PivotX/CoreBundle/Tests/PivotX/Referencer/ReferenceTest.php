<?php

namespace PivotX\CoreBundle\Component\Referencer;

use PivotX\CoreBundle\Component\Referencer\Reference;

class ReferenceTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateInitial()
    {
        $reference = new Reference(null,'/');

        $this->assertTrue($reference !== false);
    }
}
