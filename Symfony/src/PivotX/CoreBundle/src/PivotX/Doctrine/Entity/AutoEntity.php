<?php

namespace PivotX\Doctrine\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 */
class AutoEntity
{
    protected $redirect_instance = false;

    protected function getRedirectInstance()
    {
        if ($this->redirect_instance === false) {
            $_p = explode('\\',get_class($this));
            $name = $_p[count($_p)-1];

            echo "autoentity-name[".$name."]\n";

            $class = '\\PivotX\\Doctrine\\AutoEntity\\' . $name;

            $this->redirect_instance = new $class($this);
        }

        return $this->redirect_instance;
    }

    public function __call($name, $args)
    {
        $instance = $this->getRedirectInstance();

        if ($instance !== false) {
            return call_user_func_array($name,$args);
        }

        // @todo should throw error

        return null;
    }
}
