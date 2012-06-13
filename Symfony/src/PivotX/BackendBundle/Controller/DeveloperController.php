<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DeveloperController extends Controller
{
    public static function cmpRoutePrefixes($a, $b)
    {
        $af = $a->getFilter();
        $bf = $b->getFilter();
        $ret = strcasecmp($af['site'], $bf['site']);
        if ($ret != 0) {
            return $ret;
        }
        $ret = strcasecmp($af['target'], $bf['target']);
        if ($ret != 0) {
            return $ret;
        }
        $ret = strcasecmp($af['language'], $bf['language']);
        if ($ret != 0) {
            return $ret;
        }
        return strcasecmp($a->getPrefix(), $b->getPrefix());
    }

    public static function cmpRoute($a, $b)
    {
        $af = $a->getFilter();
        $bf = $b->getFilter();
        if ((count($af['site']) == 0) && (count($bf['site']) > 0)) {
            return -1;
        }
        if ((count($af['site']) > 0) && (count($bf['site']) == 0)) {
            return +1;
        }
        if ((count($af['target']) == 0) && (count($bf['target']) > 0)) {
            return -1;
        }
        if ((count($af['target']) > 0) && (count($bf['target']) == 0)) {
            return +1;
        }
        if ((count($af['language']) == 0) && (count($bf['language']) > 0)) {
            return -1;
        }
        if ((count($af['language']) > 0) && (count($bf['language']) == 0)) {
            return +1;
        }
        if ((count($af['site']) > 0) && (count($bf['site']) > 0)) {
            $ret = strcasecmp($af['site'][0], $bf['site'][0]);
            if ($ret != 0) {
                return $ret;
            }
        }
        if ((count($af['target']) > 0) && (count($bf['target']) > 0)) {
            $ret = strcasecmp($af['target'][0], $bf['target'][0]);
            if ($ret != 0) {
                return $ret;
            }
        }
        if ((count($af['language']) > 0) && (count($bf['language']) > 0)) {
            $ret = strcasecmp($af['language'][0], $bf['language'][0]);
            if ($ret != 0) {
                return $ret;
            }
        }
        $ret = strcasecmp($a->getEntity(), $b->getEntity());
        if ($ret != 0) {
            return $ret;
        }
        return strcasecmp($a->getEntityFilter(), $b->getEntityFilter());
    }

    public function showRoutingAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $prefixeses = $this->get('pivotx.routing')->getRouteSetup()->getRoutePrefixeses();
        $prefixes   = array();
        foreach($prefixeses as $p) {
            $prefixes = array_merge($prefixes, $p->getAll());
        }
        // @todo we shouldn't do this when we have priorities
        usort($prefixes, array(get_class($this), 'cmpRoutePrefixes'));

        $collections = $this->get('pivotx.routing')->getRouteSetup()->getRouteCollections();
        $routes      = array();
        foreach($collections as $c) {
            $routes = array_merge($routes, $c->getAll());
        }
        // @todo we shouldn't do this when we have priorities
        usort($routes, array(get_class($this), 'cmpRoute'));

        $context = array(
            'html' => $html,
            'prefixes' => new \PivotX\Component\Views\ArrayView($prefixes, 'Developing/Routing/Prefixes', 'PivotX/Devend', 'Dynamic view to show the routeprefixes'),
            'routes' => new \PivotX\Component\Views\ArrayView($routes, 'Developing/Routing/Routes', 'PivotX/Devend', 'Dynamic view to show the routes')
        );

        return $this->render('BackendBundle:Developer:routing.html.twig', $context);
    }

    public static function cmpViews($a, $b)
    {
        $ret = strcasecmp($a->getGroup(),$b->getGroup());
        if ($ret != 0) {
            return $ret;
        }

        return strcasecmp($a->getName(),$b->getName());
    }

    public function showViewsAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $views = $this->get('pivotx.views')->getRegisteredViews();

        usort($views, array(get_class($this), 'cmpViews'));

        $context = array(
            'html' => $html,
            'items' => new \PivotX\Component\Views\ArrayView($views, 'Developing/Views', 'Dynamic view to show all views')
        );

        return $this->render('BackendBundle:Developer:views.html.twig', $context);
    }

    public static function cmpFormats($a, $b)
    {
        $ret = strcasecmp($a->getGroup(),$b->getGroup());
        if ($ret != 0) {
            return $ret;
        }

        return strcasecmp($a->getName(),$b->getName());
    }

    public function showFormatsAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $formats = $this->get('pivotx.formats')->getRegisteredFormats();

        usort($formats, array(get_class($this), 'cmpFormats'));

        $context = array(
            'html' => $html,
            'items' => new \PivotX\Component\Views\ArrayView($formats, 'Developing/Formats', 'Dynamic view to show all formats')
        );

        return $this->render('BackendBundle:Developer:formats.html.twig', $context);
    }
}

