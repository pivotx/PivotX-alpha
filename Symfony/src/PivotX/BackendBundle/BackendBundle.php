<?php

namespace PivotX\BackendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BackendBundle extends Bundle
{
    public function boot()
    {
        try {
            $service = $this->container->get('pivotx_routing');

            $fname = dirname(__FILE__).'/Resources/config/pivotxrouting.yml';
            $service->load($fname);
        }
        catch (\InvalidArgumentException $e) {
        }
    }
}
