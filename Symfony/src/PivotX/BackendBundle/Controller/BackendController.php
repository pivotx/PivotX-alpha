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
        $views  = $this->get('pivotx_views');

        //*
        $twig = $this->get('twig');
        //$twig->addFunction('loadall', new \Twig_Function_Method($this,'testLoadall'));
        //*/

        //*
        $twig->addExtension(new \PivotX\Component\Twigquery\Twigquery());

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
        $twig->addExtension(new \PivotX\Component\Twigquery\Twigquery());

        return $this->render('BackendBundle:Core:dashboard.html.twig', array('html' => $html));
    }

    public function showTableAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $crud = array(
            'entity' => $request->get('entity')
        );

        //echo '<pre>'; var_dump($request); echo '</pre>';

        $routematch = $request->get('_routematch');
        $my_reference = $routematch->buildReference();
        echo $my_reference->buildTextReference()."<br/>\n";



        // @todo this is silly, 4 lines for building an url

        $routesetup = $this->get('pivotx_routing')->getRouteSetup();
        $reference =  new \PivotX\Component\Referencer\Reference($my_reference, '_table/'.$crud['entity'].'/1');
        $routematch = $routesetup->matchReference($reference);
        $link = $routematch->buildUrl();



        var_dump($link);
        $items = array(
            array(
                'link' => $link,
                'record' => array(
                    'id' => 1,
                    'title' => 'Dit is de titel',
                )
            )
        );

        $twig = $this->get('twig');
        $twig->addExtension(new \PivotX\Component\Twigquery\Twigquery());

        return $this->render('BackendBundle:Crud:table.html.twig', array('html' => $html, 'crud' => $crud, 'items' => $items));
    }

    public function showRecordAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $crud = array(
            'entity' => $request->get('entity')
        );

        $item = array(
            'id' => 1,
            'title' => 'Dit is de titel'
        );

        $twig = $this->get('twig');
        $twig->addExtension(new \PivotX\Component\Twigquery\Twigquery());

        return $this->render('BackendBundle:Crud:record.html.twig', array('html' => $html, 'crud' => $crud, 'item' => $item));
    }
}
