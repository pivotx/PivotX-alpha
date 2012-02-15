<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    protected $response;
    protected $request;
    protected $configuration;

    /**
     * Set up some things we'll need in most/all actions..
     */
    public function __construct()
    {


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




}
