<?php

namespace PivotX\Doctrine\Map;


class Mapping
{
    public function __construct()
    {
    }

    public function loadMapping()
    {
        $driver = new StaticPHPDriver('/path/to/entities');
        $em->getConfiguration()->setMetadataDriverImpl($driver);
    }
}


?>
