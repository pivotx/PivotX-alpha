<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Referencer;

use PivotX\Component\Referencer\Reference;

/**
 * Test various reference syntaxes
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class ReferenceTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyReference()
    {
        $reference = new Reference();
        $this->assertTrue($reference !== false);

        $this->assertEquals($reference->getBestValue('entity','default-test'),'default-test');
    }

    public function testSimpleNamedEntity()
    {
        $reference = new Reference(null,'page/contact');
        $this->assertTrue($reference->getEntity() === 'page');
        $this->assertTrue($reference->getFilter() === 'contact');

        $reference = new Reference(null,'archive');
        $this->assertTrue($reference->getEntity() === 'archive');
        $this->assertTrue($reference->getFilter() === false);
    }

    public function testSimpleNumericEntity()
    {
        $reference = new Reference(null,'entry/234');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
    }

    public function testTitleResource()
    {
        $reference = new Reference(null,'title@entry/234');
        $this->assertTrue($reference->getValue() === 'title');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
    }

    public function testMainQuery()
    {
        $reference = new Reference(null,'title@entry/234?arguments=345');
        $this->assertTrue($reference->getValue() === 'title');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
        $this->assertTrue($reference->getQuery() === 'arguments=345');
    }

    public function testSitePartial()
    {
        $reference = new Reference(null,'(site=example.com)@entry/234');
        $this->assertTrue($reference->getSite() === 'example.com');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
    }

    public function testTargetPartial()
    {
        $reference = new Reference(null,'(target=mobile)@entry/234');
        $this->assertTrue($reference->getTarget() === 'mobile');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
    }

    public function testMixedPartial()
    {
        $reference = new Reference(null,'subtitle(target=mobile)@entry/234');
        $this->assertTrue($reference->getValue() === 'subtitle');
        $this->assertTrue($reference->getTarget() === 'mobile');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');

        $reference = new Reference(null,'subtitle(site=example.org)@entry/234');
        $this->assertTrue($reference->getValue() === 'subtitle');
        $this->assertTrue($reference->getSite() === 'example.org');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
    }

    public function testLanguageExample()
    {
        $reference = new Reference(null,'(language=nl)@entry/234');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
        $this->assertTrue($reference->getLanguage() === 'nl');
    }

    public function testImplicitAnchor()
    {
        $reference = new Reference(null,'entry/234#?comments');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
        $this->assertTrue($reference->getAnchorEntity() === false);
        $this->assertTrue($reference->getAnchorFilter() === false);
        $this->assertTrue($reference->getAnchorQuery() === 'comments');
    }

    public function testCompleteExample()
    {
        $reference = new Reference(null,'title(site=example.com&target=mobile&language=nl)@entry/234?args=233&text=Marcel#page/contact?rest');
        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
        $this->assertTrue($reference->getValue() === 'title');
        $this->assertTrue($reference->getSite() === 'example.com');
        $this->assertTrue($reference->getTarget() === 'mobile');
        $this->assertTrue($reference->getLanguage() === 'nl');
        $this->assertTrue($reference->getQuery() === 'args=233&text=Marcel');
        $this->assertTrue($reference->getAnchorEntity() === 'page');
        $this->assertTrue($reference->getAnchorFilter() === 'contact');
        $this->assertTrue($reference->getAnchorQuery() === 'rest');
    }

    public function testRelativeReference()
    {
        $master = new Reference(null,'(site=example.com&target=desktop&language=en)@entry/234');
        $reference = new Reference($master,'page/contact');

        $this->assertTrue($reference->getEntity() === 'page');
        $this->assertTrue($reference->getSite() === 'example.com');
        $this->assertTrue($reference->getLanguage() === 'en');
        $this->assertTrue($reference->getValue() === 'link');
        $this->assertTrue($reference->getTarget() === 'desktop');
    }

    public function testArrayReference()
    {
        $arr = array(
            'value' => 'title',
            'language' => 'en',
            'target' => 'mobile',
            'site' => 'example.com',
            'entity' => 'entry',
            'filter' => '234',
            'query' => 'args=233&text=Marcel',
            'anchor_entity' => 'page',
            'anchor_filter' => 'about',
            'anchor_query' => 'nothing',
        );
        $reference = new Reference(null,$arr);

        $this->assertTrue($reference->getEntity() === 'entry');
        $this->assertTrue($reference->getFilter() === '234');
        $this->assertTrue($reference->getValue() === 'title');
        $this->assertTrue($reference->getSite() === 'example.com');
        $this->assertTrue($reference->getTarget() === 'mobile');
        $this->assertTrue($reference->getLanguage() === 'en');
        $this->assertTrue($reference->getQuery() === 'args=233&text=Marcel');
        $this->assertTrue($reference->getAnchorEntity() === 'page');
        $this->assertTrue($reference->getAnchorFilter() === 'about');
        $this->assertTrue($reference->getAnchorQuery() === 'nothing');
    }

    public function setReferenceFilter()
    {
        $reference = new Reference(null,'main/desktop(nl)@page/234');
        $this->assertEquals($reference->getRouteFilter(),array('site' => 'main', 'target' => 'desktop', 'language' => 'nl'));
    }
}
