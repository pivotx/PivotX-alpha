<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PivotX\Component\Routing\RouteMatch;



class DebugController extends Controller
{
    public static function convertArguments(array $arguments, $to_public)
    {
        $converts = array();

        //echo '<pre>'; var_dump($arguments); echo '</pre>';

        if ($to_public === true) {
            if (isset($arguments['id'])) {
                $converts['publicid'] = 'public-'.$arguments['id'];
            }
        }
        else {
            if (isset($arguments['publicid'])) {
                $converts['id'] = substr($arguments['publicid'],7);
            }
        }

        return $converts;
    }

    private function dumpRequest($request)
    {
        $html = '';

        $html .= '<ul>';
        $keys = $request->attributes->keys();
        foreach($keys as $key) {
            $value = $request->attributes->get($key);

            if (is_scalar($value)) {
                $value = '"' . $value . '"';
            }
            else if (is_array($value)) {
                $value = 'array';
                //$value = var_export($value,true);
            }
            else if (is_object($value)) {
                $value = 'class '.get_class($value);
            }

            $html .= '<li>key[ '.$key.' ] =&gt; '.$value.'</li>';
        }
        $html .= '</ul>';

        $routematch = $request->attributes->get('_routematch');

        $urls = $routematch->getLanguageUrls();
        $html .= '<br/><strong>Language URLs</strong><ul>';
        foreach($urls as $name => $href) {
            $html .= '<li><a href="'.$href.'">'.$name.'</a> ('.$href.')</li>';
        }
        $html .= '</ul>';

        $urls = $routematch->getTargetUrls();
        $html .= '<br/><strong>Target URLs</strong><ul>';
        foreach($urls as $name => $href) {
            $html .= '<li><a href="'.$href.'">'.$name.'</a> ('.$href.')</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public function showHomeAction(Request $request)
    {
        $html  = '<!DOCTYPE html>'."\n";
        $html .= '<html>'."\n".'<body>';

        $html .= get_class($request);

        if (true) {
            $html .= '<pre>';
            $html .= var_export($request->attributes->keys(),true);
            $html .= var_export($request->request,true);
            $html .= var_export($request->query,true);
            $html .= '</pre>';
        }

        $routematch = $request->attributes->get('_routematch');

        $html .= 'url[ ' .$routematch->buildUrl() . ' ]<br/>';

        $html .= $this->dumpRequest($request);
        $html .= '</body></html>';

        return new Response($html);
    }

    public function showArchiveAction(Request $request, $yearmonth)
    {
        $html  = '<!DOCTYPE html>'."\n";
        $html .= '<html>'."\n".'<body>';
        $html .= 'showArchiveAction met yearmonth='.$yearmonth;
        $html .= $this->dumpRequest($request);
        $html .= '</body></html>'."\n";

        return new Response($html);
    }

    public function showEntityAction(Request $request, $id)
    {
        $html  = '<!DOCTYPE html>'."\n";
        $html .= '<html>'."\n".'<body>';
        $html .= 'showEntityAction met id='.$id;
        $html .= $this->dumpRequest($request);
        $html .= '</body></html>'."\n";

        return new Response($html);
    }
}
