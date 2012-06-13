<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Formats;

use Symfony\Component\HttpKernel\Log\LoggerInterface;


class Formats
{
    private static $formats_service = false;
    private static $logger = false;

    public static function setServices(\PivotX\Component\Formats\Service $service, LoggerInterface $logger)
    {
        self::$formats_service = $service;
        self::$logger         = $logger;
    }

    public static function loadFormat($name)
    {
        if (self::$logger === false) {
            // @todo should never be here, and should do something else if here anyway
            return;
        }

        $format = self::$format_service->findFormat($name);

        if (is_null($format)) {
            // @todo throw an exception?
            //echo "format not found\n";
            self::$logger->err('Call for loadFormat "'.$name.'" - format not found');
            return false;
        }

        self::$logger->info('Call for loadFormat "'.$name.'" - format found');

        return $format;
    }
}
