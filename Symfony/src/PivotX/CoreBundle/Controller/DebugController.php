<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DebugController extends Controller
{
    
    public function showEntity($id)
    {
        return 'Id returned is "'.$id.'"';
        //return $this->render('PivotXCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
