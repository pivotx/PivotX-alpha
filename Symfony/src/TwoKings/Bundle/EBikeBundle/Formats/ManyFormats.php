<?php
/**
 * Many formatting conversion in this file.
 *
 * Normally you would want proper classes per kind of formatting.
 */

namespace TwoKings\Bundle\EBikeBundle\Formats;

use \PivotX\Component\Formats\AbstractFormat;

class ManyFormats extends AbstractFormat
{
    public function format($in, $arguments = array())
    {
        switch ($this->name) {
            case 'Weight/kg':
                if ($in < 1) {
                    return '';
                }
                return number_format($in / 1000, 1, ',', '.').' kg';
                break;

            case 'Price/EUR':
                if ($in < 1) {
                    return '';
                }
                return '€ '.number_format($in / 100, 2, ',', '.');
                break;

            case 'Distance/km':
                if ($in < 1) {
                    return '';
                }
                return number_format($in, 0, ',', '.').' km';
                break;

            case 'Querystring':
                $out = '';
                if (count($arguments) >= 4) {
                    $in[$arguments[2]] = $arguments[3];
                }
                if (count($arguments) >= 2) {
                    $in[$arguments[0]] = $arguments[1];
                }
                foreach($in as $k => $v) {
                    if ($out != '') {
                        $out .= '&';
                    }
                    $out .= $k . '=' . rawurlencode($v);
                }
                return $out;

            case 'Date/long':
                if (is_int($in)) {
                    $utime = $in;
                }
                else if ($in instanceof \DateTime) {
                    $utime = $in->getTimestamp();
                }
                else if (is_string($in) && ($in == (int) $in)) {
                    $utime = (int) $in;
                }
                return strftime('%e %B %Y, %H:%S', $utime);
        }

        return $in . ' ('.$this->name.')';
    }
}
