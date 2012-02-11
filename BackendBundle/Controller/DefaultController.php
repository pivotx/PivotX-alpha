<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('PivotXBackendBundle:Default:index.html.twig');
    }
}
