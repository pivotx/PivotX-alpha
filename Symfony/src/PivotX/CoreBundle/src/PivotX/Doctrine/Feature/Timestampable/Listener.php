<?php

namespace PivotX\Doctrine\Feature\Timestampable;

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

        if ($entity->isNullDateCreated()) {
            $entity->setDateCreated(new \DateTime());
        }
        $entity->setDateModified(new \DateTime());
    }

    // @todo should be removed
    public function onFlush(EventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        $update_nulls = array();
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            if (!isset($update_nulls[get_class($entity)])) {
                if ($entity->isNullPublicid()) {
                    $update_nulls[get_class($entity)] = $entity;
                }
                else if ($entity->isNullResourceId()) {
                    $update_nulls[get_class($entity)] = $entity;
                }
            }
        }
        
        if (count($update_nulls) > 0) {
            $connection = $em->getConnection();

            foreach($update_nulls as $class => $entity) {
                echo "update nulls for class $class\n";
                $classmetadata = $em->getClassMetadata($class);
                echo "table ".$classmetadata->table['name']."\n";
                var_dump($classmetadata->table);


                /*
                $connection->update(
                    $classmetadata->table('name'],
                    array ( 'publicid' => 'id' ),
                    array ( 'publicid' => '
                    */

                echo 'onflush'."\n";
                //$this->fixIds($em,$class);
            }
        }
    }
}
