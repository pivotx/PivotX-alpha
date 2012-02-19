<?php


namespace PivotX\CoreBundle\Util;

/**
 * A collection of miscellaneous tools, that can be used in various places.
 */
abstract class Tools
{

    /**
     * Returns a "safe" version of the given string - basically only US-ASCII and
     * numbers. Needed because filenames and titles and such, can't use all characters.
     *
     * @param string $str
     * @param boolean $strict
     * @return string
     */
    public static function safeString($str, $strict=false, $extrachars="")
    {

        // replace UTF-8 non ISO-8859-1 first
        $str = strtr($str, array(
            "\xC3\x80"=>'A', "\xC3\x81"=>'A', "\xC3\x82"=>'A', "\xC3\x83"=>'A',
            "\xC3\x84"=>'A', "\xC3\x85"=>'A', "\xC3\x87"=>'C', "\xC3\x88"=>'E',
            "\xC3\x89"=>'E', "\xC3\x8A"=>'E', "\xC3\x8B"=>'E', "\xC3\x8C"=>'I',
            "\xC3\x8D"=>'I', "\xC3\x8E"=>'I', "\xC3\x8F"=>'I', "\xC3\x90"=>'D',
            "\xC3\x91"=>'N', "\xC3\x92"=>'O', "\xC3\x93"=>'O', "\xC3\x94"=>'O',
            "\xC3\x95"=>'O', "\xC3\x96"=>'O', "\xC3\x97"=>'x', "\xC3\x98"=>'O',
            "\xC3\x99"=>'U', "\xC3\x9A"=>'U', "\xC3\x9B"=>'U', "\xC3\x9C"=>'U',
            "\xC3\x9D"=>'Y', "\xC3\xA0"=>'a', "\xC3\xA1"=>'a', "\xC3\xA2"=>'a',
            "\xC3\xA3"=>'a', "\xC3\xA4"=>'a', "\xC3\xA5"=>'a', "\xC3\xA7"=>'c',
            "\xC3\xA8"=>'e', "\xC3\xA9"=>'e', "\xC3\xAA"=>'e', "\xC3\xAB"=>'e',
            "\xC3\xAC"=>'i', "\xC3\xAD"=>'i', "\xC3\xAE"=>'i', "\xC3\xAF"=>'i',
            "\xC3\xB1"=>'n', "\xC3\xB2"=>'o', "\xC3\xB3"=>'o', "\xC3\xB4"=>'o',
            "\xC3\xB5"=>'o', "\xC3\xB6"=>'o', "\xC3\xB8"=>'o', "\xC3\xB9"=>'u',
            "\xC3\xBA"=>'u', "\xC3\xBB"=>'u', "\xC3\xBC"=>'u', "\xC3\xBD"=>'y',
            "\xC3\xBF"=>'y', "\xC4\x80"=>'A', "\xC4\x81"=>'a', "\xC4\x82"=>'A',
            "\xC4\x83"=>'a', "\xC4\x84"=>'A', "\xC4\x85"=>'a', "\xC4\x86"=>'C',
            "\xC4\x87"=>'c', "\xC4\x88"=>'C', "\xC4\x89"=>'c', "\xC4\x8A"=>'C',
            "\xC4\x8B"=>'c', "\xC4\x8C"=>'C', "\xC4\x8D"=>'c', "\xC4\x8E"=>'D',
            "\xC4\x8F"=>'d', "\xC4\x90"=>'D', "\xC4\x91"=>'d', "\xC4\x92"=>'E',
            "\xC4\x93"=>'e', "\xC4\x94"=>'E', "\xC4\x95"=>'e', "\xC4\x96"=>'E',
            "\xC4\x97"=>'e', "\xC4\x98"=>'E', "\xC4\x99"=>'e', "\xC4\x9A"=>'E',
            "\xC4\x9B"=>'e', "\xC4\x9C"=>'G', "\xC4\x9D"=>'g', "\xC4\x9E"=>'G',
            "\xC4\x9F"=>'g', "\xC4\xA0"=>'G', "\xC4\xA1"=>'g', "\xC4\xA2"=>'G',
            "\xC4\xA3"=>'g', "\xC4\xA4"=>'H', "\xC4\xA5"=>'h', "\xC4\xA6"=>'H',
            "\xC4\xA7"=>'h', "\xC4\xA8"=>'I', "\xC4\xA9"=>'i', "\xC4\xAA"=>'I',
            "\xC4\xAB"=>'i', "\xC4\xAC"=>'I', "\xC4\xAD"=>'i', "\xC4\xAE"=>'I',
            "\xC4\xAF"=>'i', "\xC4\xB0"=>'I', "\xC4\xB1"=>'i', "\xC4\xB4"=>'J',
            "\xC4\xB5"=>'j', "\xC4\xB6"=>'K', "\xC4\xB7"=>'k', "\xC4\xB8"=>'k',
            "\xC4\xB9"=>'L', "\xC4\xBA"=>'l', "\xC4\xBB"=>'L', "\xC4\xBC"=>'l',
            "\xC4\xBD"=>'L', "\xC4\xBE"=>'l', "\xC4\xBF"=>'L', "\xC5\x80"=>'l',
            "\xC5\x81"=>'L', "\xC5\x82"=>'l', "\xC5\x83"=>'N', "\xC5\x84"=>'n',
            "\xC5\x85"=>'N', "\xC5\x86"=>'n', "\xC5\x87"=>'N', "\xC5\x88"=>'n',
            "\xC5\x89"=>'n', "\xC5\x8A"=>'N', "\xC5\x8B"=>'n', "\xC5\x8C"=>'O',
            "\xC5\x8D"=>'o', "\xC5\x8E"=>'O', "\xC5\x8F"=>'o', "\xC5\x90"=>'O',
            "\xC5\x91"=>'o', "\xC5\x94"=>'R', "\xC5\x95"=>'r', "\xC5\x96"=>'R',
            "\xC5\x97"=>'r', "\xC5\x98"=>'R', "\xC5\x99"=>'r', "\xC5\x9A"=>'S',
            "\xC5\x9B"=>'s', "\xC5\x9C"=>'S', "\xC5\x9D"=>'s', "\xC5\x9E"=>'S',
            "\xC5\x9F"=>'s', "\xC5\xA0"=>'S', "\xC5\xA1"=>'s', "\xC5\xA2"=>'T',
            "\xC5\xA3"=>'t', "\xC5\xA4"=>'T', "\xC5\xA5"=>'t', "\xC5\xA6"=>'T',
            "\xC5\xA7"=>'t', "\xC5\xA8"=>'U', "\xC5\xA9"=>'u', "\xC5\xAA"=>'U',
            "\xC5\xAB"=>'u', "\xC5\xAC"=>'U', "\xC5\xAD"=>'u', "\xC5\xAE"=>'U',
            "\xC5\xAF"=>'u', "\xC5\xB0"=>'U', "\xC5\xB1"=>'u', "\xC5\xB2"=>'U',
            "\xC5\xB3"=>'u', "\xC5\xB4"=>'W', "\xC5\xB5"=>'w', "\xC5\xB6"=>'Y',
            "\xC5\xB7"=>'y', "\xC5\xB8"=>'Y', "\xC5\xB9"=>'Z', "\xC5\xBA"=>'z',
            "\xC5\xBB"=>'Z', "\xC5\xBC"=>'z', "\xC5\xBD"=>'Z', "\xC5\xBE"=>'z',
            ));

        // utf8_decode assumes that the input is ISO-8859-1 characters encoded
        // with UTF-8. This is OK since we want US-ASCII in the end.
        $str = trim(utf8_decode($str));

        $str = strtr($str, array("\xC4"=>"Ae", "\xC6"=>"AE", "\xD6"=>"Oe", "\xDC"=>"Ue", "\xDE"=>"TH",
            "\xDF"=>"ss", "\xE4"=>"ae", "\xE6"=>"ae", "\xF6"=>"oe", "\xFC"=>"ue", "\xFE"=>"th"));

        $str=str_replace("&amp;", "", $str);

        $delim = '/';
        if ($extrachars != "") {
            $extrachars = preg_quote($extrachars, $delim);
        }
        if ($strict) {
            $str = strtolower(str_replace(" ", "-", $str));
            $regex = "[^a-zA-Z0-9_".$extrachars."-]";
        } else {
            $regex = "[^a-zA-Z0-9 _.,".$extrachars."-]";
        }

        $str = preg_replace("$delim$regex$delim", "", $str);

        return $str;
    }




    /**
     * Modify a string, so that we can use it for URI's. Like
     * safeString, but using hyphens instead of underscores.
     *
     * @param string $str
     * @return string
     */
    public static function makeSlug($str)
    {

        $str = Tools::safeString($str, false, " /_-+");

        $str = preg_replace("/[ \/_\-+.]/i", "-", $str);
        $str = strtolower(preg_replace("/[^a-zA-Z0-9_-]/i", "", $str));
        $str = preg_replace("/[-]+/i", "-", $str);

        $str = substr($str,0,128); // 128 chars ought to be long enough.

        // Make sure the URI isn't numeric. We can't have that, because it'll get
        // confused with the ids.
        if (is_numeric($str)) {
            $str = "c-".$str;
        }

        return $str;

    }

    /**
     * Modify a slug-like string, so it prints better
     *
     * @param string $str
     * @return string
     */
    public static function unSlug($str)
    {

        $smallwordsarray = array(
            'of','a','the','and','an','or','nor','but','is','if','then', 'else',
            'when', 'at','from','by','on','off','for','in','out', 'over','to','into','with',
            'van', 'de', 'der', 'het', 'een'
        );

        $str = strtolower(str_replace("-", " ", $str));

        $words = explode(' ', $str);
        foreach ($words as $key => $word)
        {
            if ( ($key == 0) || (!in_array($word, $smallwordsarray)))
            $words[$key] = ucfirst($word);
        }

        $str = implode(' ', $words);
        return $str;

    }



    /**
     * Remove trailing whitespace from a given string. Not just spaces and linebreaks,
     * but also &nbsp;, <br />'s and the like.
     */
    public static function stripTrailingSpace($text)
    {

        $text=trim($text)."[[end]]";
        $end_p = preg_match("~</p>\[\[end\]\]$~mi", $text);
        $text = preg_replace("~(&nbsp;|<br>|<br />|<p>|</p>|\n|\r|\t| )*\[\[end\]\]$~mi", "", $text);
        if ($end_p) { $text.="</p>"; }

        return $text;
    }


    /**
     * Ensures that a path has no trailing slash
     *
     * @param string $path
     * @return string
     */
    public static function stripTrailingSlash($path)
    {
        if(substr($path,-1,1) == "/") {
            $path = substr($path,0,-1);
        }
        return $path;
    }


    /**
     * Ensures that a path has a trailing slash
     *
     * @param string $path
     * @return string
     */
    public static function addTrailingSlash($path)
    {
        if(substr($path,-1,1) != "/") {
            $path .= "/";
        }
        return $path;
    }


    /**
     * Make a reference for an entity, template, user, or whatnot.
     *
     * @param string $entity
     * @param array $parameters
     */
    public static function makeReference($entity="unknown", $parameters = array())
    {

        // Make sure $parameters is an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }

        $parts = array();

        $parts[] = $entity;

        // Add the contenttype, but only for certain entities.
        if ( in_array($entity, array("content", "response", "taxonomy")) ) {
            if (!empty($parameters['type'])) {
                $parts[] = "/" . Tools::safeString($parameters['type']);
            } else {
                $parts[] = "/generic";
            }
        }

        // Put together the id
        $id = array();
        if (!empty($parameters['slug'])) {
            $id[] = Tools::makeSlug($parameters['slug']);
        }
        if (!empty($parameters['name'])) {
            $id[] = Tools::makeSlug($parameters['name']);
        }
        if (!empty($parameters['date'])) {
            $date = ( is_object($parameters['date']) ? $parameters['date']->format("Y-m-d H:i:s") : $parameters['date']);
            $id[] = Tools::makeSlug($date);
        }
        if (!empty($parameters['id'])) {
            $id[] = intval($parameters['id']);
        }

        if (!empty($parameters['grouping']) && $parameters['grouping'] != $parameters['id']) {
            $id[] = $parameters['grouping'];
        }

        $parts[] = "/" . implode(",", $id);

        // Add an optional language.
        if (!empty($parameters['language'])) {
            $parts[] = "/" . Tools::safeString($parameters['language']);
        }


        // Put it together..
        $reference = implode("", $parts);

        return $reference;

    }

    /**
     * Makes a random key with the specified length.
     *
     * @param int $length
     * @return string
     */
    public static function makeKey($length)
    {

        $seed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $len = strlen($seed);
        $key = "";

        for ($i=0;$i<$length;$i++) {
            $key .= $seed[ rand(0,$len) ];
        }

        return $key;

    }

    /**
     * Make a simple array consisting of key=>value pairs, that can be used
     * in select-boxes in forms.
     *
     * @param array $array
     * @param string $key
     * @param string $value
     */
    public static function makeValuepairs($array, $key, $value)
    {

            $temp_array = array();

            if (is_array($array)) {
                    foreach($array as $item) {
                            if (empty($key)) {
                                $temp_array[] = $item[$value];
                            } else {
                                $temp_array[$item[$key]] = $item[$value];
                            }

                    }
            }

            return $temp_array;

    }




    /**
     * Make the 'excerpt', used for displaying entries and pages on the dashboard
     * as well as on the Entries and Pages overview screens.
     *
     * @param string $str
     * @param int $length
     * @return string
     */
    public static function makeExcerpt($str, $length=180, $hellip=false)
    {

        // Ensure that the excerpt is parsed but prevent the [[smarty]] tags from being executed
        // $str = parse_intro_or_body($str, false, 0, true);
        // remove the [[smarty]] tags for clean output
        $str = preg_replace('/\[\[.*\]\]/', ' ', $str);

        $from = array("&quot;", "\n", "\r", ">");
        $to = array('"', " ", " ", "> ");

        $excerpt = str_replace($from, $to, $str);
        $excerpt = strip_tags(@html_entity_decode($excerpt, ENT_NOQUOTES, 'UTF-8'));
        $excerpt = trim(preg_replace("/\s+/i", " ", $excerpt));
        $excerpt = Tools::trimText($excerpt, $length, false, $hellip);

        return $excerpt;

    }



    /**
     * Trim a text to a given length, taking html entities into account.
     *
     * Formerly we first removed entities (using unentify), cut the text at the
     * wanted length and then added the entities again (using entify). This caused
     * lot of problems so now we are using a trick from
     * http://www.greywyvern.com/code/php/htmlwrap.phps
     * where entities are replaced by the ACK (006) ASCII symbol, the text cut and
     * then the entities reinserted.
     *
     * @param string $str string to trim
     * @param int $length position where to trim
     * @param boolean $nbsp whether to replace spaces by &nbsp; entities
     * @param boolean $hellip whether to add &hellip; entity at the end
     *
     * @return string trimmed string
     */
    public static function trimText($str, $length, $nbsp=false, $hellip=true, $striptags=true) {

        if ($striptags) {
            $str = strip_tags($str);
        }

        $str = trim($str);

        // Use the ACK (006) ASCII symbol to replace all HTML entities temporarily
        $str = str_replace("\x06", "", $str);
        preg_match_all("/&([a-z\d]{2,7}|#\d{2,5});/i", $str, $ents);
        $str = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x06", $str);

        if (function_exists('mb_strwidth') ) {
            if (mb_strwidth($str)>$length) {
                $str = mb_strimwidth($str,0,$length+1, '', 'UTF-8');
                if ($hellip) {
                    $str .= '&hellip;';
                }
            }
        } else {
            if (strlen($str)>$length) {
                $str = substr($str,0,$length+1);
                if ($hellip) {
                    $str .= '&hellip;';
                }
            }
        }

        if ($nbsp==true) {
            $str=str_replace(" ", "&nbsp;", $str);
        }

        $str=str_replace("http://", "", $str);

        // Put captured HTML entities back into the string
        foreach ($ents[0] as $ent) {
            $str = preg_replace("/\x06/", $ent, $str, 1);
        }

        return $str;

    }

}
