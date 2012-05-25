<?php

namespace TwoKings\Bundle\EBikeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('TwoKingsEBikeBundle:Default:index.html.twig', array('name' => $name));
    }
}
