<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace TwoKings\Bundle\EBikeBundle\Views;

use PivotX\Component\Views\Service as ViewsService;

/**
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service
{
    protected $pivotx_views = false;
    protected $doctrine_registry = false;

    /**
     */
    public function __construct(ViewsService $pivotx_views, \Symfony\Bundle\DoctrineBundle\Registry $doctrine_registry)
    {
        $this->pivotx_views      = $pivotx_views;
        $this->doctrine_registry = $doctrine_registry;

        $view = new loadSortedBrands($this->doctrine_registry, 'Brand/loadSorted');
        $view->setRange(null, null);
        $this->pivotx_views->registerView($view);
        unset($view);

        $view = new loadBikeResults($this->doctrine_registry, 'Bike/loadResults');
        $this->pivotx_views->registerView($view);
        unset($view);

        $view = new loadBikeReviews($this->doctrine_registry, 'Bike/loadReviews');
        $this->pivotx_views->registerView($view);
        unset($view);

        /*
        $view = new \PivotX\Component\Views\ArrayView(
            array(
                '-2000' => 'licht',
                '2000-5000' => 'normaal',
                '5000-' => 'zwaar',
            ),
            'BikeSelection/getWeights', 'TwoKings/EBikeBundle', 'Option list for weights'
        );
        $this->pivotx_views->registerView($view);
        */

        $view = new \PivotX\Component\Views\ArrayView(
            array(
                '-25' => 'licht (tot 25 kg)',
                '25-35' => 'normaal (25 tot 35 kg)',
                '35-' => 'zwaar (35 kg of meer)'
            ),
            'BikeSelection/getWeights', 'TwoKings/EBikeBundle', 'Option list for weights'
        );
        $this->pivotx_views->registerView($view);

        $view = new \PivotX\Component\Views\ArrayView(
            array(
                '-50' => 'kort (tot 50 km)',
                '50-100' => 'middel (50 t/m 100 km)',
                '100-' => 'lang (100 km of meer)'
            ),
            'BikeSelection/getRanges', 'TwoKings/EBikeBundle', 'Option list for distances'
        );
        $this->pivotx_views->registerView($view);

        $view = new \PivotX\Component\Views\ArrayView(
            array(
                '-1500' => 'goedkoop (tot € 1000)',
                '1500-2500' => 'gemiddeld (€ 1500 t/m € 2500)',
                '2500-' => 'duur (€ 2500 of meer)'
            ),
            'BikeSelection/getPrices', 'TwoKings/EBikeBundle', 'Option list for priceranges'
        );
        $this->pivotx_views->registerView($view);
    }
}
