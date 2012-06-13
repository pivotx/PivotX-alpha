<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Twig;

use PivotX\Component\Routing\Service as RoutingService;
use PivotX\Component\Translations\Service as TranslationsService;
use PivotX\Component\Formats\Service as FormatsService;

/**
 * Twig Query interface
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service extends \Twig_Extension
{
    protected $environment = false;
    protected $pivotx_routing = false;
    protected $pivotx_translations = false;
    protected $pivotx_formats = false;

    /**
     */
    public function __construct(RoutingService $pivotx_routing, TranslationsService $pivotx_translations, FormatsService $pivotx_formats)
    {
        $this->pivotx_routing      = $pivotx_routing;
        $this->pivotx_translations = $pivotx_translations;
        $this->pivotx_formats      = $pivotx_formats;
    }

    /**
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'pivotx';
    }

    public function getFunctions()
    {
        return array(
            'ref' =>  new \Twig_Function_Method($this, 'getReference'),
            'translate' => new \Twig_Function_Method($this, 'getTranslate'),
            'pagination' => new \Twig_Function_Method($this, 'getPagination')
        );
    }

    public function getFilters()
    {
        return array(
            'formatas' => new \Twig_Filter_Method($this, 'filterFormatAs')
        );
    }

    public function getTokenParsers()
    {
        return array(
            new Loadview()
            // new Loadall()
        );
    }

    /**
     * Shortcut into the Reference/Routing system
     */
    public function getReference($text, $arguments = array())
    {
        $url = $this->pivotx_routing->buildUrl($text);
        return $url;
    }

    /**
     * Shortcut into the translation system
     */
    public function getTranslate($key, $sitename = null, $encoding = 'html')
    {
        return $this->pivotx_translations->translate($key, $sitename, $encoding);
    }

    /**
     * Fast pagination filler
     *
     * @todo support for multiple kinds
     * @todo get this code out of here
     */
    public function getPagination(\PivotX\Component\Views\ViewInterface $view, $link, $link_arguments = array(), $arguments = array())
    {
        $show_pages     = 9;
        $want_firstlast = true;
        $want_prevnext  = true;
        $no_of_pages    = $view->getNoOfPages();

        $current_page = $view->getCurrentPage();

        $first_page = $current_page - floor($show_pages / 2);
        if ($first_page < 1) {
            $first_page = 1;
        }

        $last_page = $first_page + $show_pages - 1;
        if ($last_page > $no_of_pages) {
            $last_page = $no_of_pages;
        }
        

        // update the actual link with all arguments

        $query_arguments = $view->getQueryArguments();
        if (is_array($link_arguments)) {
            $query_arguments = array_merge($query_arguments, $link_arguments);
        }

        foreach($query_arguments as $key => $value) {
            if (strpos($link, '?') === false) {
                $link .= '?';
            }
            else {
                $link .= '&';
            }

            $link .= $key . '=' . $value;
        }


        $array = array();

        if (($current_page > 1) && ($want_firstlast)) {
            $page_link = $this->getReference(sprintf($link, 1));
            $array[] = array( 'page' => 1, 'class' => 'first', 'title' => $this->getTranslate('pagination.first-page'), 'link' => $page_link );
        }
        if (($current_page > 1) && ($want_prevnext)) {
            $page_link = $this->getReference(sprintf($link, $current_page-1));
            $array[] = array( 'page' => $current_page-1, 'class' => 'previous', 'title' => $this->getTranslate('pagination.previous-page'), 'link' => $page_link );
        }

        for($page=$first_page; $page <= $last_page; $page++) {
            $page_link = $this->getReference(sprintf($link, $page));
            $class     = false;

            if ($page == $current_page) {
                $class = 'active';
            }

            $array[] = array ( 'page' => $page, 'class' => $class, 'title' => $page, 'link' => $page_link );
        }

        if (($current_page < $no_of_pages) && ($last_page != $no_of_pages)) {
            $page_link = $this->getReference(sprintf($link, $no_of_pages));

            $array[] = array ( 'page' => false, 'class' => 'disabled', 'title' => '...', 'link' => false );

            $array[] = array ( 'page' => $no_of_pages, 'class' => false, 'title' => $no_of_pages, 'link' => $page_link );
        }

        if (($current_page < $no_of_pages) && ($want_prevnext)) {
            $page_link = $this->getReference(sprintf($link, $current_page+1));
            $array[] = array( 'page' => $current_page+1, 'class' => 'next', 'title' => $this->getTranslate('pagination.next-page'), 'link' => $page_link );
        }
        if (($current_page < $no_of_pages) && ($want_firstlast)) {
            $page_link = $this->getReference(sprintf($link, $no_of_pages));
            $array[] = array( 'page' => $no_of_pages, 'class' => 'last', 'title' => $this->getTranslate('pagination.last-page'), 'link' => $page_link );
        }

        $view = new \PivotX\Component\Views\ArrayView($array, 'Common/Pagination', 'PivotX/Core', 'This is a dynamic view for pagination');

        return $view;
    }

    public function filterFormatAs($in, $name = '')
    {
        $out = $in;

        $format = $this->pivotx_formats->findFormat($name);
        if (!is_null($format)) {
            $arguments = array();
            if (func_num_args() > 2) {
                $arguments = func_get_args();
                array_shift($arguments);
                array_shift($arguments);
            }
            $out = $format->format($in, $arguments);
        }

        return $out;
    }
}
