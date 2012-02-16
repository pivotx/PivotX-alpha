<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ElementsController extends Controller
{

    /**
     * Set up some things we'll need in most/all actions..
     */
    public function __construct()
    {

    }


    /**
     * @Route("/navbar", name="navbar")
     * @Template()
     */
    public function navbarAction()
    {
        
        $cms = $this->get('cms');

        $contenttypes = $cms->getContentTypes();        
                   
        return array('contenttypes' => $contenttypes);
    }




}
