<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Twigquery;

/**
 * Twig Query interface
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Twigquery extends \Twig_Extension
{
    protected $environment = false;

    /**
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'twigquery';
    }

    public function getFunctions()
    {
        return array(
            '*LoadAll' =>  new \Twig_Function_Method($this,'entityLoadAll'),
            '*LoadOne' =>  new \Twig_Function_Method($this,'entityLoadOne'),
        );
    }

    public function getTokenParsers()
    {
        return array(
            new Loadview(),
            new Loadall()
        );
    }

    protected function entityLoadGeneric($name, $arguments)
    {
        $records = array(
            array('id'=>1,'title'=>'('.$name.') Dit is een test'),
            array('id'=>2,'title'=>'('.$name.') We gaan nog even door..'),
            array('id'=>99,'title'=>'('.$name.') '.$arguments)
        );

        return $records;
    }

    public function entityLoadAll($name, $arguments=null)
    {
        $records = $this->entityLoadGeneric($name, $arguments);
        return $records;
    }

    public function entityLoadOne($name, $arguments=null)
    {
        $records = $this->entityLoadGeneric($name, $arguments);
        if ((!is_array($records)) || (count($records) == 0)) {
            return null;
        }
        return $records[0];
    }

    public function getData($name, $arguments=null)
    {
        return $name;
    }
}
