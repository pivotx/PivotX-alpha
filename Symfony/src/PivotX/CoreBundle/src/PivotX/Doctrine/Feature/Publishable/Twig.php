<?php

namespace PivotX\Doctrine\Feature\Publishable;


/**
 * Maybe this should be it's own Twig Extension
 * It looks like it, but it isn't
 *
 * @todo decide this
 */
class Twig extends \Twig_Extension
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
        return 'pivotx.doctrine.publishable';
    }

    public function getFunctions()
    {
        return array(
            'isPublished' => new \Twig_Function_Method($this, 'isPublished')
        );
    }

    public function isPublished($entity)
    {
        if (method_exists($entity,'getPublishState')) {
            return in_array($entity->getPublishState(), array('published', 'timed-depublish'));
        }

        // @todo unsupported
        return false;
    }
}
