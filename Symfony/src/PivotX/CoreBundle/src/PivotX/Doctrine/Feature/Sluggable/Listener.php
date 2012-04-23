<?php

namespace PivotX\Doctrine\Feature\Sluggable;

use Doctrine\Common\EventArgs;

/**
 */
class Listener implements \Doctrine\Common\EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'prePersist'
        );
    }

    public function prePersist(EventArgs $args)
    {
        $entity = $args->getEntity();

        $entity->setSlug('test-slug');
    }
}
