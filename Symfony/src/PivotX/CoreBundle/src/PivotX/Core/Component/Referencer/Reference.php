<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Core\Component\Referencer;

/**
 * A Reference is an internal link
 *
 * @todo should this be in Routing?
 * @todo setTextReference is a bit of a mess
 * @todo rewrite to new style reference?
 *
 * Complete reference:
 * value:site/target(language)@entity/filter?query#entity/filter?query
 * ----- --------------------- --------------- ---------------
 * A     B                     C               D
 *
 * A = denotes what to return for the reference
 * B = defines the return environment
 * C = represent the specific content where to link to
 * D = where to set the focus on the return page
 *
 * Example partial references:
 * page/contact
 * title@page/contact
 * example.org/@page/contact
 * subtitle:example.org/@page/contact
 * /desktop@page/contact
 * (nl)@page/contact#?comments
 *
 * New style - Complete reference:
 * value:s=site&d=device&l=language@entity/filter?query#entity/filter?query
 * ----- -------------------------- ------------------- ---------------
 * A     B                          C                   D
 * 
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Reference
{
    /**
     * Parent Reference
     *
     * The link is relative to this reference.
     */
    private $parent = false;

    /**
     * If the current state is valid
     */
    private $valid = false;

    /**
     * Site to create the link for
     */
    private $site = false;

    /**
     * The actual value you want to return of the page-resource
     *
     * Usual values include 'link', 'abslink', 'locallink'.
     * Please note that 'link' is always the shortest working
     * link from the current page.
     */
    private $value = 'link';

    /**
     * Entity of the resource
     */
    private $entity = false;

    /**
     * Filter the resource
     *
     * Single resources have a simple numeric or single name.
     */
    private $filter = false;

    /**
     * Query request information
     */
    private $query = false;

    /**
     * Language
     */
    private $language = false;

    /**
     * Target device
     *
     * You can target 'desktop', 'mobile', whatever target you have defined.
     */
    private $target = false;

    /**
     * Anchor entity
     */
    private $anchor_entity = false;

    /**
     * Anchor filter
     */
    private $anchor_filter = false;

    /**
     * Anchor query
     */
    private $anchor_query = false;


    /**
     * Constructor.
     *
     * @param Reference $parent     parent reference
     * @param mixed     $link       either a string with string-reference or
     *                              an associative array containing reference
     *                              attributes
     */
    public function __construct(Reference $parent = null, $link = false)
    {
        $this->setParent($parent);
        $this->setLink($link);
    }

    /**
     * Set the parent reference
     *
     * This method implements a fluent interface.
     *
     * @param mixed $parent Parent reference
     * @return $this
     */
    public function setParent(Reference $parent = null)
    {
        if (is_null($parent)) {
            $this->parent = false;
        }
        else {
            $this->parent = $parent;
        }

        return $this;
    }

    /**
     * Decode a link to a reference
     *
     * This method implements a fluent interface.
     *
     * @param mixed $link Link to decode
     * @return $this
     */
    public function setLink($link)
    {
        if (is_scalar($link)) {
            $this->setTextReference($link);
        }
        else if (is_array($link)) {
            $this->setArrayReference($link);
        }

        return $this;
    }

    /**
     * Set the array to the proper internal values
     *
     * @param array $data associative array with values
     * @return boolean    true if array has been processed
     */
    private function processReferenceArray($data)
    {
        foreach($data as $k => $v) {
            if (isset($this->$k)) {
                $this->$k = $v;
            }
        }

        if ($this->entity !== false) {
            $this->valid = true;
        }

        return true;
    }

    /**
     * Parse a text reference to internal attributes
     *
     * @return boolean     true if text link was syntactically ok
     */
    public function setTextReference($_link)
    {
        $link              = $_link;
        $value_site_target = false;
        $value             = false;
        $anchor            = false;
        $language          = false;
        $values            = array();

        if (strpos($link,'#') !== false) {
            list($link,$anchor) = explode('#',$link,2);
        }
        if (strpos($link,'@') !== false) {
            list($value_site_target,$link) = explode('@',$link,2);
        }
        if (strpos($link,'?') !== false) {
            list($link,$query) = explode('?',$link,2);
            $values['query'] = $query;
        }

        if ($value_site_target) {
            if (preg_match('|^([^(]*)([(]([^)]+)[)])$|',$value_site_target,$match)) {
                $value_site_target = $match[1];
                if (count($match) > 2) {
                    $values['language'] = $match[3];
                }
            }
            $value_site = false;
            $pos = strpos($value_site_target,'/');
            if ($pos === false) {
                $values['value'] = $value_site_target;
            }
            else {
                $value_site = substr($value_site_target,0,$pos);
                $values['target'] = substr($value_site_target,$pos+1);
            }
            if ($value_site !== false) {
                $pos = strpos($value_site,':');
                if ($pos === false) {
                    $values['site'] = $value_site;
                }
                else {
                    $values['value'] = substr($value_site,0,$pos);
                    $values['site']  = substr($value_site,$pos+1);
                }
            }
        }
        if ($link) {
            $pos = strpos($link,'/');
            if ($pos === false) {
                $values['entity'] = $link;
            }
            else {
                $values['entity'] = substr($link,0,$pos);
                $values['filter'] = substr($link,$pos+1);
            }
        }
        if ($anchor && preg_match('|^([^/?]+)?(/([^?]+))?([?](.+))?|',$anchor,$match)) {
            if ($match[1] != '') {
                $values['anchor_entity'] = $match[1];
            }
            if ($match[3] != '') {
                $values['anchor_filter'] = $match[3];
            }
            $values['anchor_query']  = $match[5];
        }

        return $this->processReferenceArray($values);
    }

    /**
     * Copy link array to internal attributes
     *
     * @return boolean     true if array link containted syntactically good values
     */
    public function setArrayReference($link)
    {
        return $this->processReferenceArray($link);
    }

    /**
     * Get the best value
     *
     * @param string $name     name of the property to get
     * @param mixed  $default  default value if none found
     */
    public function getBestValue($name, $default = false)
    {
        if (!$this->valid) {
            return $default;
        }
        if ($this->$name !== false) {
            return $this->$name;
        }
        if ($this->parent !== false) {
            return $this->parent->getBestValue($name,$default);
        }
        return $default;
    }

    /**
     * Get the value argument
     *
     * @return string    resource type value
     */
    public function getValue()
    {
        return $this->getBestValue('value','link');
    }

    /**
     * Get the site argument
     *
     * @return string  site name
     */
    public function getSite()
    {
        return $this->getBestValue('site','link');
    }

    /**
     * Get the entity argument
     *
     * @return string entity name
     */
    public function getEntity()
    {
        return $this->getBestValue('entity',false);
    }

    /**
     * Get the entity filter
     *
     * @return string id value
     */
    public function getFilter()
    {
        return $this->getBestValue('filter',false);
    }

    /**
     * Get query
     *
     * @return string query
     */
    public function getQuery()
    {
        return $this->getBestValue('query',false);
    }

    /**
     * Get the target argument
     *
     * @return string target value
     */
    public function getTarget()
    {
        return $this->getBestValue('target',false);
    }

    /**
     * Get the language argument
     *
     * @return string language value
     */
    public function getLanguage()
    {
        return $this->getBestValue('language',false);
    }

    /**
     * Get the anchor entity argument
     *
     * @return string anchor entity
     */
    public function getAnchorEntity()
    {
        if ($this->anchor_entity === false) {
            return $this->getBestValue('entity',false);
        }
        return $this->anchor_entity;
    }

    /**
     * Get the anchor entity filter
     *
     * @return string anchor filter
     */
    public function getAnchorFilter()
    {
        if ($this->anchor_filter === false) {
            return $this->getBestValue('filter',false);
        }
        return $this->anchor_filter;
    }

    /**
     * Get the anchor query
     *
     * @return string anchor other
     */
    public function getAnchorQuery()
    {
        return $this->getBestValue('anchor_query',false);
    }

    /**
     * Get a simplified filter from this reference
     *
     * @return array simplified filter
     */
    public function getRouteFilter()
    {
        return array(
            'site' => $this->getSite(),
            'target' => $this->getTarget(),
            'language' => $this->getLanguage(),
        );
    }
}
