<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('PivotXBackendBundle_homepage', new Route('/hello/{name}', array(
    '_controller' => 'PivotXBackendBundle:Default:index',
)));
$collection->add('PivotXBackendBundle_test', new Route('/test', array(
    '_controller' => 'PivotXBackendBundle:Default:test',
)));

return $collection;
