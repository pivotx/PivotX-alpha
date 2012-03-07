<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class DebugController extends Controller
{
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

        $html .= '</body></html>';

        return new Response($html);
    }

    public function showEntityAction($id)
    {
        return 'Id returned is "'.$id.'"';
        //return $this->render('PivotXCoreBundle:Default:index.html.twig', array('name' => $name));
    }

    public function showArchiveAction($yearmonth)
    {
        $html = 'showArchiveAction met yearmonth='.$yearmonth;

        return new Response($html);
    }
}
