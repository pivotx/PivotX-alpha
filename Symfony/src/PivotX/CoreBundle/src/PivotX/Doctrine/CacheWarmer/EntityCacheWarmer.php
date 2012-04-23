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
        echo 'PivotX Doctrine Warmer'."\n";

        $this->registry = $registry;
    }

    // @todo currently doubled in PivotXCoreBundle
    public function getEntityCode($name)
    {
        $entity = new \PivotX\Doctrine\Entity\GenerateEntity($name);

        $code  = '<'.'?php'."\n";
        $code .= "namespace PivotX\Doctrine\Entity\n{\n\n";
        $code .= $entity->generateCode();
        $code .= "\n}\n";

        return $code;
    }

    public function warmUp($cacheDir)
    {
        //echo 'warmUp: Cache dir is '.$cacheDir."\n";

        if (!is_dir($cacheDir.'/PivotX')) {
            mkdir($cacheDir.'/PivotX');
        }

        file_put_contents($cacheDir.'/PivotX/Entry.php', $this->getEntityCode('Entry'));
        file_put_contents($cacheDir.'/PivotX/EntryLanguage.php', $this->getEntityCode('EntryLanguage'));
    }

    public function isOptional()
    {
        return false;
    }
}
