<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BackendController extends Controller
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

        $webresource = new \PivotX\Component\Webresourcer\Webresource('jquery', '1.7.1');
        $webresource = new \PivotX\Component\Webresourcer\Webresource(
            'twitter-bootstrap',
            '2012.02.17',
            array(
                'jquery'
            )
        );

        return $this->render('BackendBundle:Default:dashboard.html.twig', array('html' => $html));
    }

    public function showTestAction()
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $records = array(
            array('id'=>1,'title'=>'Dit is een test')
        );
        //$records = array();

        $logger = $this->get('logger');
        $views  = $this->get('pivotx.views');

        //*
        $twig = $this->get('twig');
        //$twig->addFunction('loadall', new \Twig_Function_Method($this,'testLoadall'));
        //*/

        //*
        //$twig->addExtension(new \PivotX\Component\Twigquery\Twigquery());

        //$ids = $this->container->getServiceIds();
        //$logger->info('services',$ids);
        //$logger->info(implode("\n",$ids));
        //*/

        return $this->render('BackendBundle:Default:test.html.twig', array('html' => $html, 'records' => $records));
    }

    public function showDashboardAction()
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $twig = $this->get('twig');
        //$twig->addExtension(new \PivotX\Component\Twigquery\Twigquery());

        return $this->render('BackendBundle:Core:dashboard.html.twig', array('html' => $html));
    }
}
