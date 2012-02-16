<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use PivotX\CoreBundle\Util\Tools;
use PivotX\CoreBundle\Entity\Content;
use PivotX\CoreBundle\Entity\Taxonomy;
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


    /**
     * @Route("/import/categories")
     * @Template()
     */
    public function importCategoriesAction()
    {

        $em = $this->getDoctrine()->getEntityManager();


        $conn = $this->get('database_connection');
        $cats = $conn->fetchAll('SELECT DISTINCT(category) FROM pivotx_categories WHERE category!="" ');
        $cats = Tools::makeValuepairs($cats, '', 'category');

        foreach($cats as $cat) {

            $name = Tools::unSlug($cat);
            echo "<br />Name: $name";

            $query = $em->createQuery("SELECT t FROM PivotXCoreBundle:Taxonomy t WHERE t.slug= :slug AND t.taxonomytype = :type ")
                ->setParameter('slug', $cat)
                ->setParameter('type', 'category');

            $res = $query->getArrayResult();

            // Create it, if it's not there yet.
            if (empty($res)) {

                $taxonomy = new Taxonomy();
                $taxonomy->setTaxonomytype('category');
                $taxonomy->setName($name);
                $taxonomy->setSlug($cat);

                $em->persist($taxonomy);
                $em->flush();

            }

        }

        return new Response('<html><head></head><body>Ready!</body></html>');

    }

    /**
     * @Route("/import/tags")
     * @Template()
     */
    public function importTagsAction()
    {

        $em = $this->getDoctrine()->getEntityManager();


        $conn = $this->get('database_connection');
        $tags = $conn->fetchAll('SELECT DISTINCT(tag) FROM pivotx_tags WHERE tag!="" LIMIT 10000;');
        $tags = Tools::makeValuepairs($tags, '', 'tag');

        foreach($tags as $tag) {

            $name = Tools::unSlug($tag);
            echo "<br />Name: $name";

            $query = $em->createQuery("SELECT t FROM PivotXCoreBundle:Taxonomy t WHERE t.slug= :slug AND t.taxonomytype = :type ")
                ->setParameter('slug', $tag)
                ->setParameter('type', 'tag');

            $res = $query->getArrayResult();

            // Create it, if it's not there yet.
            if (empty($res)) {

                $taxonomy = new Taxonomy();
                $taxonomy->setTaxonomytype('tag');
                $taxonomy->setName($name);
                $taxonomy->setSlug($tag);

                $em->persist($taxonomy);
                $em->flush();

            }

        }

        return new Response('<html><head></head><body><br /><br />Ready!</body></html>');

    }


    /**
     * @Route("/import/chapters")
     * @Template()
     */
    public function importChapterAction()
    {

        $em = $this->getDoctrine()->getEntityManager();


        $conn = $this->get('database_connection');
        $chapters = $conn->fetchAll('SELECT * FROM pivotx_chapters;');

        foreach($chapters as $chapter) {

            echo "<br />Name: " . $chapter['chaptername'];

            $slug = Tools::makeSlug($chapter['chaptername']);

            $query = $em->createQuery("SELECT t FROM PivotXCoreBundle:Taxonomy t WHERE t.slug= :slug AND t.taxonomytype = :type ")
                ->setParameter('slug', $slug)
                ->setParameter('type', 'chapter');

            $res = $query->getArrayResult();

            // Create it, if it's not there yet.
            if (empty($res)) {

                $taxonomy = new Taxonomy();
                $taxonomy->setTaxonomytype('chapter');
                $taxonomy->setName($chapter['chaptername']);
                $taxonomy->setSlug($slug);
                $taxonomy->setDescription($chapter['description']);
                $taxonomy->setSortingorder($chapter['sortorder']);

                $em->persist($taxonomy);
                $em->flush();

            }

        }

        return new Response('<html><head></head><body><br /><br />Ready!</body></html>');

    }



    /**
     * @Route("/import/pages")
     * @Template()
     */
    public function importPagesAction()
    {

        $em = $this->getDoctrine()->getEntityManager();

        $conn = $this->get('database_connection');
        $pages = $conn->fetchAll('SELECT p.*, c.chaptername FROM `pivotx_pages` p LEFT JOIN pivotx_chapters as c ON (c.uid = p.chapter) LIMIT 1000;');

        echo "<pre>";

        foreach($pages as $page) {

            echo "\nPage: " . $page['uri'];


            $query = $em->createQuery("SELECT c FROM PivotXCoreBundle:Content c WHERE c.slug= :slug AND c.dateCreated = :date ")
                ->setParameter('slug', $page['uri'])
                ->setParameter('date', $page['date']);

            $res = $query->getArrayResult();

            // Create it, if it's not there yet.
            if (empty($res)) {

                $content = new Content();
                $content->setTitle($page['title']);
                $content->setSlug($page['uri']);
                $content->setGrouping(0);
                $content->setTeaser($page['introduction']);
                $content->setBody($page['body']);
                $content->setDateCreated(new \DateTime($page['date']));
                $content->setDateModified(new \DateTime($page['edit_date']));
                $content->setDatePublishOn(new \DateTime($page['publish_date']));
                $content->setLanguage("NL");
                $content->setStatus($page['status']);
                $content->setTemplate($page['template']);
                $content->setTextFormatting($page['convert_lb']);
                $content->setAllowResponses($page['allow_comments']);
                $content->setLocked(0);
                $content->setSearchable(0);
                $content->setContenttype("page");


                $em->persist($content);
                $em->flush();

                $slug = Tools::makeSlug($page['chaptername']);

                echo " - chap == ". $slug;

                $taxonomy = $this->getDoctrine()->getRepository('PivotXCoreBundle:Taxonomy')->findOneBySlug($slug);

                $tr = new Taxonomyrelation();
                $tr->setSortingOrder($page['sortorder']);
                $tr->setContent($content);
                $tr->setTaxonomy($taxonomy);


                $em->persist($tr);
                $em->flush();


            } else {
                echo " - Skip!";
            }

        }

        return new Response('<html><head></head><body></pre><br /><br />Ready!</body></html>');

    }



}
