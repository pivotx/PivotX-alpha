<?php

namespace PivotX\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CrudController extends Controller
{
    protected function getEntityClass($name)
    {
        $ems = $this->container->get('doctrine')->getEntityManagers();
        foreach ($ems as $em) {
            $classes = $em->getMetadataFactory()->getAllMetadata();
            foreach($classes as $class) {
                //echo "Class: ".$class->name."\n";
                //var_dump($class);

                $_p = explode('\\',$class->name);
                $base_class = $_p[count($_p)-1];

                if ($base_class == $name) {
                    return $class->name;
                }

                //var_dump($paths,$base_class);
                //echo 'Base-class: '.$base_class."\n";
            }
        }

        return null;
    }

    protected function getForm($em, $item)
    {
        $form_items = array();
        if ($em) {
            $class = $em->getClassMetadata(get_class($item));
            if ($class) {
                foreach($class->fieldMappings as $mapname => $mapping) {
                    if (isset($mapping['id']) && ($mapping['id'] === true)) {
                        // always ignore id field
                        continue;
                    }

                    $name = $mapname;
                    $type = null;
                    $args = array();

                    $args['label'] = $mapname . ' ('.$mapping['type'].')';

                    //*
                    switch ($mapping['type']) {
                        case 'datetime':
                            $type = 'datetime';
                            $args['date_widget'] = 'single_text';
                            $args['time_widget'] = 'single_text';
                            break;

                        case 'boolean':
                            $type = 'checkbox';
                            $args['required'] = false;
                            break;

                        case 'integer':
                            $type = 'number';
                            $args['precision'] = 0;
                            break;

                        case 'text':
                            $type = 'textarea';
                            break;
                    }
                    //*/

                    // if we encounter this method, ignore this field in the crud
                    if ($item->hasMethod('getCrudIgnore_'.$mapname)) {
                        continue;
                    }
                    // if we encounter this method, overwrite arguments
                    if ($item->hasMethod('getCrudArguments_'.$mapname)) {
                        $method         = 'getCrudArguments_'.$mapname;
                        $crud_arguments = $item->$method();
                        $args           = array_merge($args,$crud_arguments);
                    }
                    // if we encounter this method, change type to 'choice' and fill in the options
                    if ($item->hasMethod('getCrudChoices_'.$mapname)) {
                        $method          = 'getCrudChoices_'.$mapname;
                        $choices         = $item->$method();
                        $type            = 'choice';
                        $args['choices'] = array();
                        foreach($choices as $choice) {
                            $label = $choice;
                            $args['choices'][$choice] = $label;
                        }
                    }
                    // only type gets overwritten
                    if ($item->hasMethod('getCrudType_'.$mapname)) {
                        $method = 'getCrudType_'.$mapname;
                        $type   = $item->$method();
                    }

                    $form_items[] = array(
                        'name' => $mapname,
                        'type' => $type,
                        'arguments' => $args
                    );
                }
            }
        }


        $builder = $this->createFormBuilder($item);
        foreach($form_items as $form_item) {
            $builder->add($form_item['name'], $form_item['type'], $form_item['arguments']);
        }
        $form = $builder->getForm();

        return $form;
    }

    public function showTableAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $crud = array(
            'htmlid' => 'id'.rand(100,999),
            'entity' => $request->get('entity')
        );

        $items = \PivotX\Component\Views\Views::loadView($crud['entity'].'/findAll');

        $widgets = array(
            'BackendBundle:CrudWidgets:General.html.twig',
            'BackendBundle:CrudWidgets:Selection.html.twig',
            'BackendBundle:CrudWidgets:ExportImport.html.twig'
        );

        $context = array(
            'html' => $html,
            'crud' => $crud,
            'widgets' => $widgets,
            'items' => $items
        );

        $table_html = $this
            ->render('TwoKingsEBikeBundle:Crud:'.$crud['entity'].'.table.html.twig', $context)
            ->getContent()
            ;

        $context['table'] = $table_html;

        return $this->render('BackendBundle:Crud:table.html.twig', $context);
    }

    public function showSubTableAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $crud = array(
            'htmlid' => 'id'.rand(100,999),
            'entity' => $request->get('entity'),
            'entityref' => $request->get('entityref'),
        );
        $entityref_class = $this->getEntityClass($crud['entityref']);

        $items = \PivotX\Component\Views\Views::loadView($crud['entity'].'/findAll');

        $em = $this->get('doctrine')->getEntityManager();
        $item = $em->find($entityref_class,$request->get('id'));

        $widgets = array(
            'BackendBundle:CrudWidgets:CommentGeneral.html.twig',
            'BackendBundle:CrudWidgets:CommentSelection.html.twig'
        );

        $context = array(
            'html' => $html,
            'crud' => $crud,
            'widgets' => $widgets,
            'items' => $items,
            'item' => $item
        );

        $table_html = $this
            ->render('TwoKingsEBikeBundle:Crud:'.$crud['entity'].'.table.html.twig', $context)
            ->getContent()
            ;

        $context['table'] = $table_html;

        return $this->render('BackendBundle:Crud:table.html.twig', $context);
    }

    public function showRecordAction(Request $request)
    {
        $html = array(
            'language' => 'en',
            'meta' => array(
                'charset' => 'utf-8',
            ),
            'title' => 'PivotX back-end'
        );

        $crud = array(
            'entity' => $request->get('entity'),
            'id' => $request->get('id')
        );
        $entity_class = $this->getEntityClass($crud['entity']);

        $em = $this->get('doctrine')->getEntityManager();

        if ($crud['id'] > 0) {
            $item = $em->find($entity_class,$crud['id']);
        }
        else {
            $item = new $entity_class;
        }

        $form = $this->getForm($em, $item);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($item);
                $em->flush();

                $url = $this->container->get('pivotx.routing')->buildUrl('_table/'.$crud['entity']);
                return $this->redirect($url);
            }
        }

        return $this->render(
            'BackendBundle:Crud:record.html.twig',
            array('html' => $html, 'crud' => $crud, 'item' => $item, 'form' => $form->createView())
        );
    }
}
