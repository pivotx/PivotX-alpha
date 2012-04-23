<?php

/*
 * @todo should be removed now?
 *
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\Extension;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;


/**
 * This is our cache warmer for pre-defined entities.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class Definition implements CacheWarmerInterface
{
    public function __construct()
    {
        //echo 'PivotX Doctrine Warmer'."\n";
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

        // @todo currently not USED (see PivotXCoreBundle.php)

        if (!is_dir($cacheDir.'/PivotX')) {
            //mkdir($cacheDir.'/PivotX');
        }

        //file_put_contents($cacheDir.'/PivotX/Entry.php', $this->getEntityCode('Entry'));
        //file_put_contents($cacheDir.'/PivotX/EntryLanguage.php', $this->getEntityCode('EntryLanguage'));
    }

    public function isOptional()
    {
        return false;
    }
}
