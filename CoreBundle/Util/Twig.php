<?php

namespace PivotX\CoreBundle\Util;

use Symfony\Component\HttpKernel\KernelInterface;

class Twig extends \Twig_Extension
{
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'totime' => new \Twig_Function_Method($this, 'toTime'),
            'vardump' => new \Twig_Function_Method($this, 'vardump'),
            
        );
    }
    
    /**
     * Converts a string to time
     * 
     * @param string $string
     * @return int 
     */
    public function toTime ($string)
    {
        return strtotime($string);
    }

    /**
     * Converts a string to time
     * 
     * @param string $string
     * @return int 
     */
    public function vardump($array)
    {
        $result = var_export($array, true);
        return ($result);
    }

    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'pivotx';
    }
}