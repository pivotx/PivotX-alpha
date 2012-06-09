<?php

namespace PivotX\Doctrine\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 */
class AutoEntity implements \ArrayAccess
{
    protected $redirect_instance = false;

    /**
     * Check for the existance of a method
     *
     * Checks the instance itself but also the redirected instance 
     */
    public function hasMethod($name)
    {
        if (method_exists($this,$name)) {
            return true;
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$name)) {
            return true;
        }
        return false;
    }

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

    /**
     * Camelize a name
     */
    protected function camelize($name)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) { return ('.' === $match[1] ? '_' : '').strtoupper($match[2]); }, $name);
    }

    /**
     * Easy access for properties
     *
     * This has only been added to properly fool the Forms component
     */
    public function __get($name)
    {
        $getname = 'get'.$this->camelize($name);
        if (method_exists($this,$getname)) {
            return $this->$getname();
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$getname)) {
            return $instance->$getname();
        }
        return null;
    }

    /**
     * Easy access for properties
     *
     * This has only been added to properly fool the Forms component
     */
    public function __set($name,$value)
    {
        $setname = 'set'.$this->camelize($name);
        if (method_exists($this,$setname)) {
            return $this->$setname($value);
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$setname)) {
            return $instance->$setname($value);
        }
        return null;
    }


    /**
     * ArrayAccess Implementation
     */
    public function offsetExists($offset)
    {
        $getname = 'get'.$this->camelize($offset);
        if (method_exists($this,$getname)) {
            return true;
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$getname)) {
            return true;
        }
        return false;
    }

    /**
     * ArrayAccess Implementation
     */
    public function offsetGet($offset)
    {
        $getname = 'get'.$this->camelize($offset);
        if (method_exists($this,$getname)) {
            return $this->$getname();
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$getname)) {
            return $instance->$getname();
        }
        return null;
    }

    /**
     * ArrayAccess Implementation
     */
    public function offsetSet($offset, $value)
    {
        $setname = 'set'.$this->camelize($offset);
        if (method_exists($this,$setname)) {
            $this->$setname($value);
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$setname)) {
            $instance->$setname($value);
        }
    }

    /**
     * ArrayAccess Implementation
     */
    public function offsetUnset($offset)
    {
        $setname = 'set'.$this->camelize($offset);
        if (method_exists($this,$setname)) {
            $this->$setname(null);
        }
        $instance = $this->getRedirectInstance();
        if (method_exists($instance,$setname)) {
            $instance->$setname(null);
        }
    }
}
