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



    /**
     * @Route("/dashboardwidget", name="dashboardwidget")
     * @Template()
     */
    public function dashboardWidgetAction()
    {

        $type = $this->getRequest()->get('type');

        $cms = $this->get('cms');

        $contenttypes = $cms->getContentTypes();

        $widgets = $cms->getWidgets();

        return array('widget' => $widgets[$type] );

    }




}
