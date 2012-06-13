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

        $view = self::$views_service->findView($name);

        if (is_null($view)) {
            // @todo throw an exception?
            //echo "view not found\n";
            self::$logger->err('Call for loadView "'.$name.'"  - view not found');
            return false;
        }

        self::$logger->info('Call for loadView "'.$name.'" - view found');

        if (!is_null($arguments)) {
            $view->setArguments($arguments);
        }

        return $view;
    }
}
