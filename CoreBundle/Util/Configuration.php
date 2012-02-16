<?php


namespace PivotX\CoreBundle\Util;


use Symfony\Component\Yaml\Yaml;

/**
 * PivotX's configuration
 */
class Configuration
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

        /*
        echo "<pre>\n";
        print_r($this->contenttypes);
        echo "</pre>\n";

        echo "<pre>\n";
        print_r($this->configuration);
        echo "</pre>\n";

        echo "<pre>\n";
        print_r($this->taxonomies);
        echo "</pre>\n";
        */
    }


    public function joe(){

        echo "joe!";

    }





}
