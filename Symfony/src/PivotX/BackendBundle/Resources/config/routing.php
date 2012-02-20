<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('PivotXBackendBundle_homepage', new Route('/hello/{name}', array(
    '_controller' => 'PivotXBackendBundle:Default:index',
)));

return $collection;
