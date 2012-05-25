<?php

/*
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\CacheWarmer;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;


/**
 * This is our cache warmer for pre-defined entities.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class EntityCacheWarmer implements CacheWarmerInterface
{
    private $registry;

    /**
     * Constructor.
     *
     * @param RegistryInterface $registry A RegistryInterface instance
     */
    public function __construct(RegistryInterface $registry)
    {
        //echo 'PivotX Doctrine Warmer'."\n";

        $this->registry = $registry;
    }

    /**
     */
    public function getEntityCode($name, $metaclassdata, $feature_configuration)
    {
        $entity = new \PivotX\Doctrine\Entity\GenerateEntity($name, $metaclassdata, $feature_configuration);

        $code  = '<'.'?php'."\n";
        $code .= "namespace PivotX\Doctrine\AutoEntity\n{\n\n";
        $code .= $entity->generateCode();
        $code .= "\n}\n";

        return $code;
    }

    /**
     * @todo yaml only
     */
    protected function getFeatureConfiguration($paths,$name)
    {
        foreach($paths as $path) {
            if (file_exists($path[0].'/'.$name.$path[1])) {
                return new \PivotX\Doctrine\Configuration\YamlConfiguration($path[0].'/'.$name.$path[1]);
            }
        }

        return null;
    }

    public function warmUp($cacheDir)
    {
        //echo 'entity.warmUp: Cache dir is '.$cacheDir."\n";

        if (!is_dir($cacheDir.'/PivotX')) {
            mkdir($cacheDir.'/PivotX');
            if (false === @mkdir($cacheDir, 0777, true)) {
                throw new \RuntimeException(sprintf('Unable to create the PivotX Doctrine Entity directory "%s".', $cacheDir));
            }
        }
        elseif (!is_writable($cacheDir)) {
            throw new \RuntimeException(sprintf('The PivotX Doctrine Entity directory "%s" is not writeable for the current system user.', $cacheDir));
        }

//        file_put_contents($cacheDir.'/PivotX/Entry.php', $this->getEntityCode('Entry'));
//        file_put_contents($cacheDir.'/PivotX/EntryLanguage.php', $this->getEntityCode('EntryLanguage'));

        foreach ($this->registry->getEntityManagers() as $em) {

            // find path and extension information
            $paths = array();
            $drivers = $em->getConfiguration()->getMetadataDriverImpl()->getDrivers();
            foreach($drivers as $driver) {
                $_paths = $driver->getPaths();
                $_ext   = $driver->getFileExtension();
                foreach($_paths as $_path) {
                    $paths[] = array($_path,$_ext);
                }
            }


            $classes = $em->getMetadataFactory()->getAllMetadata();
            foreach($classes as $class) {
                //echo "Class: ".$class->name."\n";
                //var_dump($class);

                $_p = explode('\\',$class->name);
                $base_class = $_p[count($_p)-1];

                $feature_configuration = $this->getFeatureConfiguration($paths,$base_class);

                // code generation
                $file_name = $cacheDir . '/PivotX/' . $base_class . '.php';
                file_put_contents($file_name, $this->getEntityCode($base_class,$class,$feature_configuration));
            }
        }

        //echo "entity.warmUp done\n";
    }

    public function isOptional()
    {
        return false;
    }
}
