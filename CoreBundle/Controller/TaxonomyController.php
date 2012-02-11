<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Taxonomy;
use PivotX\CoreBundle\Form\TaxonomyType;

/**
 * Taxonomy controller.
 *
 * @Route("/taxonomy")
 */
class TaxonomyController extends Controller
{
    /**
     * Lists all Taxonomy entities.
     *
     * @Route("/", name="taxonomy")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Taxonomy')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Taxonomy entity.
     *
     * @Route("/{id}/show", name="taxonomy_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Taxonomy entity.
     *
     * @Route("/new", name="taxonomy_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Taxonomy();
        $form   = $this->createForm(new TaxonomyType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Taxonomy entity.
     *
     * @Route("/create", name="taxonomy_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Taxonomy:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Taxonomy();
        $request = $this->getRequest();
        $form    = $this->createForm(new TaxonomyType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taxonomy_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Taxonomy entity.
     *
     * @Route("/{id}/edit", name="taxonomy_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomy entity.');
        }

        $editForm = $this->createForm(new TaxonomyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Taxonomy entity.
     *
     * @Route("/{id}/update", name="taxonomy_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Taxonomy:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomy entity.');
        }

        $editForm   = $this->createForm(new TaxonomyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taxonomy_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Taxonomy entity.
     *
     * @Route("/{id}/delete", name="taxonomy_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Taxonomy')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Taxonomy entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('taxonomy'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
