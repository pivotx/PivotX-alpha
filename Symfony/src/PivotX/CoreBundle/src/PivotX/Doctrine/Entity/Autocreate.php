<?php

/*
 * This file is part of the PivotX package.
 */

namespace PivotX\Doctrine\Entity;


/**
 * This code should be useless once we can create the appropriate cache warmups.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class Autocreate
{
    /**
     * Registers this instance as an autoloader.
     *
     * @param Boolean $prepend Whether to prepend the autoloader or not
     *
     * @api
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * Create the class when it's something we can create
     */
    public function loadClass($class)
    {
        $prefix = 'PivotX\\Doctrine\\Entity\\';
        if (strpos($class,$prefix) === 0) {
            $entity = substr($class,strlen($prefix));

            $generator = new GenerateEntity($entity);

            $code = $generator->generateCode();

            //echo "code[\n$code\n]\n";
            echo 'Autocreating class '.$class."\n";

            eval($code);
        }
    }
}
