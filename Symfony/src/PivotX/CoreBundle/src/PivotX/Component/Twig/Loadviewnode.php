<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Twig;

/**
 * Twig Query interface
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Loadviewnode extends \Twig_Node
{
    public function __construct($name, $view, $arguments, $lineno, $tag = null)
    {
        //parent::__construct(array('value' => $value), array('name' => $name), $lineno, $tag);
        parent::__construct(array(), array('name' => $name, 'view' => $view), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('$context[\''.$this->getAttribute('name').'\'] = ')
            //->subcompile($this->getNode('value'))
            ->write('\PivotX\Component\Views\Views::loadView("'.$this->getAttribute('view').'");')
            //->raw('array( array(\'id\'=>1,\'title\'=>\'Live teruggeven\'), array(\'id\'=>2,\'title\'=>\'Record Two\' ))')
            //->raw(";\n")
            ;
    }
}
