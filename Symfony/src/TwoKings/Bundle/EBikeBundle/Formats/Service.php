<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace TwoKings\Bundle\EBikeBundle\Formats;

use PivotX\Component\Formats\Service as FormatsService;

/**
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service
{
    protected $pivotx_formats = false;

    /**
     */
    public function __construct(FormatsService $pivotx_formats)
    {
        $this->pivotx_formats = $pivotx_formats;

        $format = new ManyFormats('Weight/kg', 'TwoKings/EBikeBundle', 'Convert grams to "##,# kg"');
        $this->pivotx_formats->registerFormat($format);

        $format = new ManyFormats('Price/EUR', 'TwoKings/EBikeBundle', 'Convert cents to "€ ###,##"');
        $this->pivotx_formats->registerFormat($format);

        $format = new ManyFormats('Distance/km', 'TwoKings/EBikeBundle', 'Convert kilometers to "### km"');
        $this->pivotx_formats->registerFormat($format);

        $format = new ManyFormats('Querystring', 'TwoKings/EBikeBundle', 'Simple way to create a querystring');
        $this->pivotx_formats->registerFormat($format);
    }
}
