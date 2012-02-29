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

    public function testAction()
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

        //*
        $twig = $this->get('twig');
        //$twig->addFunction('loadall', new \Twig_Function_Method($this,'testLoadall'));
        //*/

        $twig->addExtension(new \PivotX\Core\Component\Twigquery\Twigquery());

        $ids = $this->container->getServiceIds();
        $logger->info('services',$ids);
        $logger->info(implode("\n",$ids));

        return $this->render('PivotXBackendBundle:Default:test.html.twig', array('html' => $html, 'records' => $records));
    }
}
