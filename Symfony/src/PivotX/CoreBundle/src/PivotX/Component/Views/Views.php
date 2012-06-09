<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Views;

use Symfony\Component\HttpKernel\Log\LoggerInterface;


class Views
{
    private static $views_service = false;
    private static $logger = false;

    public static function setServices(\PivotX\Component\Views\Service $service, LoggerInterface $logger)
    {
        self::$views_service = $service;
        self::$logger        = $logger;
    }

    public static function loadView($name, $arguments = null)
    {
        if (self::$logger === false) {
            // @todo should never be here, and should do something else if here anyway
            return;
        }

        //self::$logger->info('loadView "'.$name.'" called');

        $view = self::$views_service->findView($name);

        if (is_null($view)) {
            // @todo throw an exception?
            //echo "view not found\n";
            return false;
        }


        // pagination, should it be here?

        $limit  = null;
        $offset = null;

        $limit = 15;

        if (!is_null($arguments)) {
            $view->setArguments($arguments);
        }
        $view->setRange($limit, $offset);

        return $view;
    }
}
