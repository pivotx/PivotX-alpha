<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Routing\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * RouteNotFoundHttpException.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RouteNotFoundHttpException extends NotFoundHttpException
{
    /**
     * Constructor.
     *
     * @param string    $message  The internal exception message
     * @param Exception $previous The previous exception
     * @param integer   $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }
}

