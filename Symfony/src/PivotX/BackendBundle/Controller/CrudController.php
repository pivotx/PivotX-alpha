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
                    if (method_exists($item,'getCrudIgnore_'.$mapname)) {
                        continue;
                    }
                    // if we encounter this method, overwrite arguments
                    if (method_exists($item,'getCrudArguments_'.$mapname)) {
                        $method         = 'getCrudArguments_'.$mapname;
                        $crud_arguments = $item->$method();
                        $args           = array_merge($args,$crud_arguments);
                    }
                    // if we encounter this method, change type to 'choice' and fill in the options
                    if (method_exists($item,'getCrudChoices_'.$mapname)) {
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
                    if (method_exists($item,'getCrudType_'.$mapname)) {
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

        $page_variable = $this->get('pivotx.translations')->translate('pagination.page_variable');
        if ($request->query->has($page_variable)) {
            $items->setCurrentPage($request->query->getInt($page_variable), 10);
        }
        else {
            $items->setCurrentPage(1, 10);
        }

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

        // @todo should not be hard-wired here of course
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

    public function showGetRecordAction(Request $request, $entity_manager, $item)
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

        $form = $this->getForm($entity_manager, $item);

        return $this->render(
            'BackendBundle:Crud:record.html.twig',
            array('html' => $html, 'crud' => $crud, 'item' => $item, 'form' => $form->createView())
        );
    }

    public function showPostOrPutRecordAction(Request $request, $entity_manager, $item)
    {
        $form = $this->getForm($entity_manager, $item);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity_manager->persist($item);
            $entity_manager->flush();

            $url = $this->get('pivotx.routing')->buildUrl('_table/'.$request->get('entity'));

            // only when POST
            return $this->redirect($url);
        }
    }

    public function showDeleteRecordAction(Request $request, $entity_manager, $item)
    {
        $entity_manager->remove($item);
        $entity_manager->flush();

        $data = array(
            'code' => '200',
            'message' => 'Succesfully deleted.',
        );

        $content = json_encode($data);

        return new \Symfony\Component\HttpFoundation\Response($content, $data['code']);
    }

    public function showRecordAction(Request $request)
    {
        $entity_class = $this->getEntityClass($request->get('entity'));
        $entity_manager = $this->get('doctrine')->getEntityManager();

        if ($request->get('id') > 0) {
            $item = $entity_manager->find($entity_class,$request->get('id'));
        }
        else {
            $item = new $entity_class;
        }
        

        if (in_array($request->getMethod(), array('DELETE'))) {
            return $this->showDeleteRecordAction($request, $entity_manager, $item);
        }
        if (in_array($request->getMethod(), array('POST', 'PUT'))) {
            return $this->showPostOrPutRecordAction($request, $entity_manager, $item);
        }
        if (in_array($request->getMethod(), array('GET'))) {
            return $this->showGetRecordAction($request, $entity_manager, $item);
        }
    }
}
