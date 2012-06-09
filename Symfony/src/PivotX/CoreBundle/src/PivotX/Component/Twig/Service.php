<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Twig;

use PivotX\Component\Routing\Service as RoutingService;
use PivotX\Component\Translations\Service as TranslationsService;

/**
 * Twig Query interface
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service extends \Twig_Extension
{
    protected $environment = false;
    protected $pivotx_routing = false;
    protected $pivotx_translations = false;

    /**
     */
    public function __construct(RoutingService $pivotx_routing, TranslationsService $pivotx_translations)
    {
        $this->pivotx_routing      = $pivotx_routing;
        $this->pivotx_translations = $pivotx_translations;
    }

    /**
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'pivotx';
    }

    public function getFunctions()
    {
        return array(
            'ref' =>  new \Twig_Function_Method($this,'getReference'),
            'translate' => new \Twig_Function_Method($this,'getTranslate')
        );
    }

    public function getReference($text, $arguments = array())
    {
        $url = $this->pivotx_routing->buildUrl($text);
        return $url;
    }

    /**
     */
    public function getTranslate($key, $sitename = null, $encoding = 'html')
    {
        return $this->pivotx_translations->translate($key, $sitename, $encoding);
    }

    public function getTokenParsers()
    {
        return array(
            new Loadview(),
            new Loadall()
        );
    }

    public function getData($name, $arguments=null)
    {
        return $name;
    }
}
