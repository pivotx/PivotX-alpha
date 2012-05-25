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

            $class = '\\PivotX\\Doctrine\\AutoEntity\\' . $name;

            $this->redirect_instance = new $class($this);
        }

        return $this->redirect_instance;
    }

    public function __call($name, $args)
    {
        $instance = $this->getRedirectInstance();

        if ($instance !== false) {
            switch (count($args)) {
                case 0:
                    return call_user_func(array($instance,$name));
                    break;
                case 1:
                    return call_user_func(array($instance,$name),$args[0]);
                    break;
                case 2:
                    return call_user_func(array($instance,$name),$args[0],$args[1]);
                    break;
                case 3:
                    return call_user_func(array($instance,$name),$args[0],$args[1],$args[2]);
                    break;
                case 4:
                    return call_user_func(array($instance,$name),$args[0],$args[1],$args[2],$args[3]);
                    break;
                case 5:
                    return call_user_func(array($instance,$name),$args[0],$args[1],$args[2],$args[3],$args[4]);
                    break;
                case 6:
                    return call_user_func(array($instance,$name),$args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);
                    break;
                case 7:
                    return call_user_func(array($instance,$name),$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
                    break;

                default:
                    return call_user_func_array(array($instance,$name),$args);
                    break;
            }
        }

        // @todo should throw error

        return null;
    }
}
