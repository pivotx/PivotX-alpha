<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use PivotX\Component\Routing\Language;

/**
 * Test various language settings
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class LanguageTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $language = new Language('nl','Dutch','nl_NL.utf-8');

        //$this->assertEquals($language->getName(),'nl');
        //$this->assertEquals($language->getDescription(),'Dutch');
        //$this->assertEquals($language->getLocale(),'nl_NL.utf-8');
    }
}
