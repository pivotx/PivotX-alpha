<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $webresource = new \PivotX\Core\Component\Webresourcer\Webresource('jquery', '1.7.1');
        $webresource = new \PivotX\Core\Component\Webresourcer\Webresource(
            'twitter-bootstrap',
            '2012.02.17',
            array(
                'jquery'
            )
        );

        return $this->render('PivotXBackendBundle:Default:index.html.twig', array('html' => $html));
    }
}
