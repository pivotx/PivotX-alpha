<?php

namespace PivotX\Doctrine\Feature\Identifiable;

use Doctrine\Common\EventArgs;

/**
 */
class Listener implements \Doctrine\Common\EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postPersist'
        );
    }

    protected function fixIds($entity_manager, $class)
    {
        $connection = $entity_manager->getConnection();
        $classmetadata = $entity_manager->getClassMetadata($class);

        // @todo not database agnostic at the moment!
        if (isset($classmetadata->fieldMappings['publicid'])) {
            $connection->executeUpdate('update '.$classmetadata->table['name'].' set publicid=id where publicid is null');
        }
        if (isset($classmetadata->fieldMappings['resource_id'])) {
            $connection->executeUpdate('update '.$classmetadata->table['name'].' set resource_id=id where resource_id is null');
        }
    }

    public function postPersist(EventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity->getPublicid() == '-1') {
            $entity->setPublicid($entity->getId());
        }
        if ($entity->getResourceId() == '-1') {
            $entity->setResourceId($entity->getId());
        }

        $this->fixIds($args->getEntityManager(),get_class($entity));
    }
}

