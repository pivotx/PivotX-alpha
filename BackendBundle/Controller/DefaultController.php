<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * Set up some things we'll need in most/all actions..
     */
    public function __construct()
    {
    
        // $configuration = $this->get('configuration');
    

    }


    /**
     * @Route("/", name="dashboard")
     * @Template()
     */
    public function indexAction()
    {

        $configuration = $this->get('configuration');



        return $this->render('PivotXBackendBundle:Default:index.html.twig');
    }

    /**
     * @Route("/overview/{name}", name="overview", defaults={"name"=""})
     * @Template()
     */
    public function overviewAction()
    {

        $configuration = $this->get('configuration');

        echo "joe!";

//        return $this->render('PivotXBackendBundle:Default:index.html.twig');
    }



}
