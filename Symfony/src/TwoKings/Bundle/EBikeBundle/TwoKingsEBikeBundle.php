<?php

namespace TwoKings\Bundle\EBikeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TwoKingsEBikeBundle extends Bundle
{
    public function boot()
    {
        // force loading of our views
        // @todo this is not pretty
        $ebikebundleviews = $this->container->get('ebikebundle.views');

        // force loading of our formats
        // @todo this is not pretty
        $ebikebundleformats = $this->container->get('ebikebundle.formats');
    }
}
