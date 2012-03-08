<?php


namespace PivotX\CoreBundle\Util;


use Symfony\Component\Yaml\Yaml;

/**
 * PivotX's CMS class
 */
class CMS
{

    private $contenttypes;
    private $configuration;
    private $taxonomies;

    /**
     * Construct, load the yaml files for the various configs.
     */
    function __construct() {

        $path = dirname(dirname(__DIR__))."/config/";

        $this->contenttypes = Yaml::parse($path."contenttypes.yml");
        $this->configuration = Yaml::parse($path."config.yml");
        $this->taxonomies = Yaml::parse($path."taxonomies.yml");
        $this->widgets = Yaml::parse($path."widgets.yml");

    }


    /**
     * Get all contenttypes as an array..
     */
    public function getContentTypes(){

        return $this->contenttypes;

    }


    /**
     * Get all widgets as an array..
     */
    public function getWidgets(){

        return $this->widgets;

    }





}
