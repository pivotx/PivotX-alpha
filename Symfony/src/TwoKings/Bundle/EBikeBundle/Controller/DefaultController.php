<?php

namespace TwoKings\Bundle\EBikeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    protected function getSharedContext()
    {
        $context = array(
        );

        return $context;
    }
    
    public function indexAction($name)
    {
        return $this->showAboutAction();
    }

    public function showAboutAction()
    {
        $context = $this->getSharedContext();

        return $this->render('TwoKingsEBikeBundle:Default:about.html.twig', $context);
    }

    public function showBannerAction($width = 300, $height = 350)
    {
        $context = $this->getSharedContext();

        return $this->render('TwoKingsEBikeBundle:Default:banner-'.$width.'x'.$height.'.html.twig', $context);
    }

    protected function getQueryArguments(Request $request)
    {
        $view_arguments  = array();
        $query_arguments = array();

        if ($request->query->has('sorteer') && ($request->query->get('sorteer') != '')) {
            $sorteer = $request->query->get('sorteer');
            $reverse = '';
            if (substr($sorteer, 0, 1) == '!') {
                $sorteer = substr($sorteer, 1);
                $reverse = '!';
            }
            switch ($sorteer) {
                case 'merk':
                    $view_arguments['order']    = $reverse.'brand';
                    $query_arguments['sorteer'] = $reverse.'merk';
                    break;
                case 'model':
                    $view_arguments['order']    = $reverse.'title';
                    $query_arguments['sorteer'] = $reverse.'model';
                    break;
                case 'bereik':
                    $view_arguments['order']    = $reverse.'range_avg';
                    $query_arguments['sorteer'] = $reverse.'bereik';
                    break;
                case 'prijs':
                    $view_arguments['order']    = $reverse.'price';
                    $query_arguments['sorteer'] = $reverse.'prijs';
                    break;
                case 'gewicht':
                    $view_arguments['order']    = $reverse.'weight';
                    $query_arguments['sorteer'] = $reverse.'gewicht';
                    break;
                default:
                    $view_arguments['order']    = $reverse.'title';
                    $query_arguments['sorteer'] = $reverse.'model';
                    break;
            }
        }
        else {
            $view_arguments['order']    = 'title';
            $query_arguments['sorteer'] = 'model';
        }

        if ($request->query->has('merk') && ($request->query->get('merk') != '')) {
            $view_arguments['brand'] = $request->query->get('merk');
            $query_arguments['merk'] = $request->query->get('merk');
        }
        if ($request->query->has('gewicht')) {
            if (strpos($request->query->get('gewicht'),'-') !== false) {
                list($low,$high) = explode('-',$request->query->get('gewicht'));
                $view_arguments['weight_low']  = (int) $low * 1000;
                $view_arguments['weight_high'] = (int) $high * 1000;
                $query_arguments['gewicht']    = $request->query->get('gewicht');
            }
        }
        if ($request->query->has('bereik')) {
            if (strpos($request->query->get('bereik'),'-') !== false) {
                list($low,$high) = explode('-',$request->query->get('bereik'));
                $view_arguments['range_low']  = (int) $low * 1000;
                $view_arguments['range_high'] = (int) $high * 1000;
                $query_arguments['bereik']    = $request->query->get('bereik');
            }
        }
        if ($request->query->has('prijs')) {
            if (strpos($request->query->get('prijs'),'-') !== false) {
                list($low,$high) = explode('-',$request->query->get('prijs'));
                $view_arguments['price_low']  = (int) $low * 100;
                $view_arguments['price_high'] = (int) $high * 100;
                $query_arguments['prijs']     = $request->query->get('prijs');
            }
        }

        if ($request->query->has('pagina')) {
            $query_arguments['pagina'] = $request->query->getInt('pagina');
            if ($query_arguments['pagina'] < 1) {
                $query_arguments['pagina'] = 1;
            }
        }
        else {
            $query_arguments['pagina'] = 1;
        }

        return array($view_arguments, $query_arguments);
    }

    public function showResultsAction(Request $request, $width = 300, $height = 350)
    {
        $context = $this->getSharedContext();

        $request = $this->getRequest();

        $view = $this->get('pivotx.views')->findView('Bike/loadResults');

        list($view_arguments, $query_arguments) = $this->getQueryArguments($request);

        $view->setCurrentPage($query_arguments['pagina'], 10);
        $query_arguments['pagina'] = (string) $view->getCurrentPage();

        $view->setArguments($view_arguments);
        $view->setQueryArguments($query_arguments);

        $context['bikes'] = $view;

        return $this->render('TwoKingsEBikeBundle:Default:results.html.twig', $context);
    }

    protected function getNewBikeReviewForm($bikereview)
    {
        $translations = $this->get('pivotx.translations');

        $rating_choices = array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5'
        );

        $builder = $this
            ->createFormBuilder($bikereview)
            ->add('name', 'text', array ( 'label' => $translations->translate('bikereview.form.new.name') ))
            ->add('email', 'email', array ( 'label' => $translations->translate('bikereview.form.new.email') )) 
            ->add('rating', 'choice', array ( 'label' => $translations->translate('bikereview.form.new.rating'), 'choices' =>  $rating_choices, 'expanded' => true )) 
            ->add('comment', 'textarea', array ( 'label' => $translations->translate('bikereview.form.new.comment') ))
            ;

        return $builder->getForm();
    }

    protected function updateBikeReviews($bike)
    {
        $reviews_view = $this->get('pivotx.views')->findView('Bike/loadReviews');
        $reviews_view->setArguments(array('bike' => $bike->getId()));

        $info = $reviews_view->getLengthAndRating();

        $bike->setNoOfReviews($info['length']);
        if ($info['length'] > 0) {
            $bike->setReviewRating($info['total_rating'] / $info['length']);
        }
        else {
            $bike->setReviewRating(0);
        }
    }

    public function showBikeAction(Request $request, $publicid)
    {
        $context = $this->getSharedContext();

        $repository = $this->getDoctrine()->getRepository('TwoKingsEBikeBundle:Bike');

        list($view_arguments, $query_arguments) = $this->getQueryArguments($request);

        $bike       = $repository->findOneBy(array( 'publicid' => $publicid ));
        $bikereview = new \TwoKings\Bundle\EBikeBundle\Entity\BikeReview;
        $form       = $this->getNewBikeReviewForm($bikereview);

        $reviews_view = $this->get('pivotx.views')->findView('Bike/loadReviews');
        $reviews_view->setArguments(array('bike' => $bike->getId()));

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $bikereview->setBike($bike);
                $bikereview->setDateCreated(new \DateTime());
                $bikereview->setDateModified(new \DateTime());
                $bikereview->setHttpUserAgent($request->server->get('HTTP_USER_AGENT'));
                $bikereview->setRemoteAddr($request->getClientIp());
                $bikereview->setViewable(1);

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($bikereview);
                $em->flush();

                $this->updateBikeReviews($bike);
                $em->persist($bike);
                $em->flush();

                // @todo we should go back to the proper URL
                $url = $this->container->get('pivotx.routing')->buildUrl('bike/'.$bike->getPublicid());
                return $this->redirect($url);
            }
        }

        $context['bike']                = $bike;
        $context['queryarguments']      = $query_arguments;
        $context['bikereview_new_form'] = $form->createView();
        $context['reviews']             = $reviews_view;

        return $this->render('TwoKingsEBikeBundle:Default:bike.html.twig', $context);
    }
}
