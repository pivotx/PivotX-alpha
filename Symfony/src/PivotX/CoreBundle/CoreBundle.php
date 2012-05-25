<?php

namespace PivotX\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CoreBundle extends Bundle
{
    public function boot()
    {
        //echo "Boot bundle..\n";

        try {
            $views_service = $this->container->get('pivotx_views');

            //$service->load($fname);


            $this->loadEntities();

            // loop all entities

            $doctrine_service = $this->container->get('doctrine');
            foreach ($doctrine_service->getEntityManagers() as $em) {
                $classes = $em->getMetadataFactory()->getAllMetadata();
                foreach($classes as $class) {
                    //echo "Class: ".$class->name."<br/>\n";

                    $parts = explode('\\',$class->name);
                    $name  = $parts[count($parts)-1];

                    $repository = $doctrine_service->getRepository($class->name);
                    if (is_object($repository)) {
                        //echo 'Repository: '.get_class($repository)."<br/>\n";
                        if (method_exists($repository,'addDefaultViews')) {
                            //echo "Adding defaults<br/>\n";
                            $repository->addDefaultViews($views_service,$name);
                        }
                    }
                }
            }
        }
        catch (\InvalidArgumentException $e) {
        }
    }

    public function shutdown()
    {
        //echo "Shutdown bundle..\n";
    }

    protected function loadEntities()
    {
        // @todo chicken and egg thing here.
        // @todo reading from the cache whilst it's not warm yet
        $entityDir = $this->container->getParameter('kernel.cache_dir').'/PivotX';
        if (is_dir($entityDir)) {
            $files = scandir($entityDir);
            foreach($files as $file) {
                $fname = $entityDir . '/' . $file;
                if (is_file($fname) && (substr($file,-4) == '.php')) {
                    $name = '\\PivotX\\Doctrine\\AutoEntity\\'.substr($file,0,-4);
                    if (!class_exists($name)) {
                        include_once $fname;
                    }
                }
            }
        }
    }
}
