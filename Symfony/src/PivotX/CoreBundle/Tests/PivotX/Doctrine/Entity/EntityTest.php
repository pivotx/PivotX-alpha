<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Doctrine\Entity;

require_once dirname(__DIR__).'/../../../../../../app/AppKernel.php';

use PivotX\Corebundle\Entity\Entry;

/**
 * Test various reference syntaxes
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @var Symfony\Component\HttpKernel\AppKernel
    */
    protected $kernel;

    /**
    * @var Doctrine\ORM\EntityManager
    */
    protected $entityManager;

    /**
    * @var Symfony\Component\DependencyInjection\Container
    */
    protected $container;

    public function setUp()
    {
        echo 'Setting up doctrine entitytest..'."\n";

        // Boot the AppKernel in the test environment and with the debug.
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        echo "Kernel booted..\n";

        // Store the container and the entity manager in test case properties
        $this->container = $this->kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getEntityManager();

        $this->eventManager = $this->entityManager->getEventManager();

        // @todo this should be dynamic
        /*
        $this->eventManager->addEventSubscriber(new \PivotX\Doctrine\Feature\Identifiable\Listener());
        $this->eventManager->addEventSubscriber(new \PivotX\Doctrine\Feature\Timestampable\Listener());
        $this->eventManager->addEventSubscriber(new \PivotX\Doctrine\Feature\Publishable\Listener());
        //*/

        // Build the schema for sqlite
        //$this->generateSchema();

        parent::setUp();
    }

    public function tearDown()
    {
        // Shutdown the kernel.
        $this->kernel->shutdown();

        parent::tearDown();
    }

    // added to disable the warnings
    public function testDummy()
    {
        $this->assertEquals('','');
    }

    public function xyztestBasicProperties()
    {
        $entry = new \PivotX\CoreBundle\Entity\Entry;

        $entry->setViewable('1');
        $entry->setDateCreated(new \DateTime());
        $entry->setDateModified(new \DateTime());
        $entry->setPublishState('published');
        $entry->setVersion('head');

        $this->entityManager->persist($entry);
        $this->entityManager->flush();
    }

    public function xyztestTest()
    {
        //*
        $entry = new \PivotX\CoreBundle\Entity\Entry;
        //echo 'before calling persist'."\n";
        echo 'before: id = '.$entry->getId()."\n";
        //$entry->setPublicid('news-1');
        $entry->setViewable('1');
        $entry->setDateCreated(new \DateTime());
        $entry->setDateModified(new \DateTime());
        $entry->setPublishState('published');

        var_dump($entry);

        $this->entityManager->persist($entry);
        //$this->entityManager->flush();

        return;

        echo 'after: id = '.$entry->getId()."\n";

        //*
        $el = new \PivotX\CoreBundle\Entity\EntryLanguage;

        /*
        $el->setLanguage('nl');
        $el->setSlug('nieuws-1');
        $el->setTitle('Nieuws 1');
        $el->setEnabled(1);
        //*/
        $el->setEntry($entry);

        //$entry->addLanguage($el);

        echo "before: id = ".$el->getId()."\n";

        $this->entityManager->persist($el);
        //*/

        return;

        $this->entityManager->persist($entry);

        return;

        $this->entityManager->flush();

        return;

        //echo "after: id = ".$el->getId()."\n";

        //*/

        /*
        $entry = $this->entityManager->find('PivotX\CoreBundle\Entity\Entry',1);

        echo "entry:\nid = ".$entry->getId()."\n";
        echo "publicid = ".$entry->getPublicid()."\n";
        echo "publish_state = ".$entry->getPublishState()."\n";

        $entrylanguages = $entry->getLanguages();

        echo "languages: ".count($entrylanguages)."\n";
        foreach($entrylanguages as $el) {
            echo "language: ".$el->getLanguage()."\n";
        }
        //*/

        $this->entityManager->flush();

        $this->assertTrue(1 == 1);
    }
}
