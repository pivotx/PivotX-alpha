<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Translations;

use PivotX\Component\Routing\Service as RoutingService;

/**
 * PivotX Translation Service
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Service
{
    protected $pivotx_routing = false;
    protected $doctrine_registry = false;
    protected $entity_manager = false;
    protected $entity_class = false;

    public function __construct(RoutingService $pivotx_routing, \Symfony\Bundle\DoctrineBundle\Registry $doctrine_registry)
    {
        $this->pivotx_routing    = $pivotx_routing;
        $this->doctrine_registry = $doctrine_registry;

        $this->entity_manager = $this->doctrine_registry->getEntityManager();

        $this->determineEntityClass();
    }

    protected function determineEntityClass()
    {
        $ems = $this->doctrine_registry->getEntityManagers();
        foreach ($ems as $em) {
            $classes = $em->getMetadataFactory()->getAllMetadata();
            foreach($classes as $class) {
                $_p = explode('\\',$class->name);
                $base_class = $_p[count($_p)-1];

                if ($base_class == 'TranslationText') {
                    $this->entity_class = $class->name;
                }
            }
        }
    }

    public function translate($key, $filter = null, $encoding = 'raw')
    {
        $site     = null;
        $language = null;
        if (preg_match('/&(site|s)=([^&]+)/', '&'.$filter, $match)) {
            $site = $match[1];
        }
        if (preg_match('/&(language|l)=([^&]+)/', '&'.$filter, $match)) {
            $language = $match[1];
        }

        if (is_null($site) || is_null($language)) {
            $routematch = $this->pivotx_routing->getLatestRouteMatch();
            if (!is_null($routematch)) {
                $filter = $routematch->getRoutePrefix()->getFilter();
                if (is_null($site)) {
                    $site = $filter['site'];
                }
                if (is_null($language)) {
                    $language = $filter['language'];
                }
            }
        }

        $pos = strpos($key, '.');
        if ($pos !== false) {
            $groupname = substr($key, 0, $pos);
            $name      = substr($key, $pos+1);
        }
        else {
            $groupname = 'common';
            $name      = $key;
        }

        $arguments = array(
            'groupname' => $groupname,
            'name' => $name
        );
        if (!is_null($site)) {
            $arguments['sitename'] = $site;
        }

        //$translationtext = $this->entity_manager->findOneBy($arguments);
        $translationtext = $this->doctrine_registry->getRepository($this->entity_class)->findOneBy($arguments);

        if (is_null($translationtext)) {
            $translationtext = new $this->entity_class;
            $translationtext->sitename  = $site;
            $translationtext->groupname = $groupname;
            $translationtext->name      = $name;
            $translationtext->encoding  = 'utf-8';
            // @todo when Timestampable works this should be removed
            $translationtext->date_created  = new \DateTime();
            $translationtext->date_modified = new \DateTime();
            // @todo should auto-detect languages here
            $translationtext->text_nl   = $key;
            $translationtext->text_en   = $key;
            $this->entity_manager->persist($translationtext);
            $this->entity_manager->flush();
        }

        $method = 'getText'.ucfirst($language);
        if ($translationtext->hasMethod($method)) {
            return $translationtext->$method();
        }

        return '--'.$key.'--';
    }
}
