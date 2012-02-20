<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Referencer;

/**
 * A Reference is an internal link to an actual page(-resource)
 *
 * value:site@entity/id(target,language)#entity/id:other
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
     * Numeric id of the resource (for automated links) or internal name
     * for coded links.
     *
     * 
     */
    private $id = false;

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
     * Anchor id
     */
    private $anchor_id = false;

    /**
     * Anchor rest
     */
    private $anchor_other = false;


    /**
     * Constructor.
     *
     * @param Reference $parent     parent reference
     * @param mixed $link           either a string with string-reference or
     *                              an associative array containing reference
     *                              attributes
     */
    public function __construct(Reference $parent, $link='/')
    {
        if (is_null($parent)) {
            $this->parent = new Reference(false);
        }
        else {
            $this->parent = $parent;
        }

        if (is_scalar($link)) {
            $this->setTextReference($link);
        }
        else if (is_array($link)) {
            $this->setArrayReference($link);
        }
    }

    /**
     * Set the array to the proper internal values
     *
     * @param array $data    associative array with values
     */
    protected function processReferenceArray($data)
    {
        foreach($data as $k => $v) {
            if (isset($this->$k)) {
                $this->$k = $v;
            }
        }

        return true;
    }

    /**
     * Parse a text reference to internal attributes
     *
     * @return boolean     true if text link was syntactically ok
     */
    public function setTextReference($link)
    {
        // value:site@entity/id(target,language)#entity/id:other

        $value_site      = false;
        $value           = false;
        $anchor          = false;
        $target_language = false;

        if (strpos($link,'#') !== false) {
            list($link,$anchor) = explode('#',$link,2);
        }
        if (strpos($link,'@') !== false) {
            list($value_site,$link) = explode('@',$link,2);
        }
        else if (strpos($link,':') !== false) {
            list($value,$link) = explode('@',$link,2);
        }
        if (preg_match('|^([^(]+)([(](.*)[)])$|',$link,$match)) {
            $link            = $match[1];
            $target_language = $match[3];
        }

        $values = array();
        if ($value !== false) {
            $values['value'] = $value;
        }
        if ($value_site) {
            $pos = strpos($value_site,':');
            if ($pos === false) {
                $values['site'] = $value_site;
            }
            else {
                $values['value'] = substr($value_site,0,$pos-1);
                $values['site']  = substr($value_site,$pos+1);
            }
        }
        if ($link) {
            $pos = strpos($link,'/');
            if ($pos === false) {
                $values['entity'] = $link;
            }
            else {
                $values['link'] = substr($link,0,$pos-1);
                $values['id']   = substr($link,$pos+1);
            }
        }
        if ($anchor && preg_match('|^([^/:]+?)(/([^:]+?))?(:(.+))?|',$anchor,$match)) {
            $values['anchor_entity'] = $match[1];
            $values['anchor_id']     = $match[3];
            $values['anchor_other']  = $match[5];
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
}
