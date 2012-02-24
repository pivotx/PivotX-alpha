<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use PivotX\CoreBundle\Util\Tools;
use PivotX\CoreBundle\Entity\Content;
use PivotX\CoreBundle\Entity\Taxonomy;
// use PivotX\CoreBundle\Entity\Response;
use PivotX\CoreBundle\Entity\TaxonomyRelation;



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

        return array();

    }




    /**
     * @Route("/overview/{contenttype}/{page}", name="overview", defaults={"contenttype"="", "page"=1 })
     * @Template()
     */
    public function overviewAction($contenttype, $page)
    {

        $cms = $this->get('cms');
        $contenttypes = $cms->getContentTypes();

        if (isset($contenttypes[$contenttype])) {

            $em = $this->getDoctrine()->getEntityManager();

            $pager = $em->getRepository('PivotXCoreBundle:Content')
                    ->getPagedContent($contenttype, $page, 15);

            return array('pager' => $pager, 'contenttype' => $contenttype);

        } else {

            throw new \Exception("Contenttype '$contenttype' does not exist!");

        }

    }




    /**
     * @Route("/view/{id}", name="view")
     * @Template()
     */
    public function viewAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $content = $em->getRepository('PivotXCoreBundle:Content')
                ->getContent($id);

        $contentarray = $em->getRepository('PivotXCoreBundle:Content')
                ->getContent($id, true);


        return array('content' => $content, 'contentarray' => $contentarray);


    }


}
