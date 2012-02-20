<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('PivotXCoreBundle_homepage', new Route('/hello/{name}', array(
    '_controller' => 'PivotXCoreBundle:Default:index',
)));

return $collection;
