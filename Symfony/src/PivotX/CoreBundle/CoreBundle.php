<?php

namespace PivotX\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CoreBundle extends Bundle
{
    public function boot()
    {
        echo "Boot bundle..\n";

        $this->loadEntities();


        // @todo look here: vendor/symfony/src/Symfony/Bundle/DoctrineBundle/DoctrineBundle.php
        // @todo and here: vendor/symfony/src/Symfony/Bundle/DoctrineBundle/Resources/config/orm.xml
    }

    public function shutdown()
    {
        echo "Shutdown bundle..\n";
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

    // @todo currently doubled in PivotXCoreBundle
    protected function getEntityCode($name)
    {
        $entity = new \PivotX\Doctrine\Entity\GenerateEntity($name);

        switch ($name) {
            case 'Entry':
                $entity->addPropertyClass('\\PivotX\\Doctrine\\Feature\\Identifiable\\ObjectProperty');
                $entity->addPropertyClass('\\PivotX\\Doctrine\\Feature\\Publishable\\ObjectProperty');
                $entity->addPropertyClass('\\PivotX\\Doctrine\\Feature\\Timestampable\\ObjectProperty');
                $entity->addPropertyClass('\\PivotX\\Doctrine\\Feature\\Multilingual\\ObjectProperty');
                break;
            case 'EntryLanguage':
                $entity->addPropertyClass('\\PivotX\\Doctrine\\Feature\\Sluggable\\ObjectProperty');
                break;
        }

        $code  = '<'.'?php'."\n";
        $code .= "namespace PivotX\Doctrine\Entity\n{\n\n";
        $code .= $entity->generateCode();
        $code .= "\n}\n";

        return $code;
    }


    // @todo cache generation should not be here
    public function build(ContainerBuilder $container)
    {
        echo "Build bundle..\n";

        $cacheDir = $container->getParameter('kernel.cache_dir');

        if (!is_dir($cacheDir.'/PivotX')) {
            mkdir($cacheDir.'/PivotX');
        }

//        $em = $container->get('doctrine')->getEntityManager();

        //*
        static $once = false;

        if ($once) {
            echo 'Once'."\n";
            var_dump($container);
            var_dump($this);
            $once = false;
        }
        //*/
        
        //echo get_class($em);

        // @todo this shouldn't be hardcoded
        // @todo removed already
        //file_put_contents($cacheDir.'/PivotX/Entry.php', $this->getEntityCode('Entry'));
        //file_put_contents($cacheDir.'/PivotX/EntryLanguage.php', $this->getEntityCode('EntryLanguage'));
    }
}
