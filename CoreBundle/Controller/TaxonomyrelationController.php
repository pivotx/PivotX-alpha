<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Taxonomyrelation;
use PivotX\CoreBundle\Form\TaxonomyrelationType;

/**
 * Taxonomyrelation controller.
 *
 * @Route("/taxonomyrelation")
 */
class TaxonomyrelationController extends Controller
{
    /**
     * Lists all Taxonomyrelation entities.
     *
     * @Route("/", name="taxonomyrelation")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Taxonomyrelation')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Taxonomyrelation entity.
     *
     * @Route("/{id}/show", name="taxonomyrelation_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomyrelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomyrelation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Taxonomyrelation entity.
     *
     * @Route("/new", name="taxonomyrelation_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Taxonomyrelation();
        $form   = $this->createForm(new TaxonomyrelationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Taxonomyrelation entity.
     *
     * @Route("/create", name="taxonomyrelation_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Taxonomyrelation:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Taxonomyrelation();
        $request = $this->getRequest();
        $form    = $this->createForm(new TaxonomyrelationType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taxonomyrelation_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Taxonomyrelation entity.
     *
     * @Route("/{id}/edit", name="taxonomyrelation_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomyrelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomyrelation entity.');
        }

        $editForm = $this->createForm(new TaxonomyrelationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Taxonomyrelation entity.
     *
     * @Route("/{id}/update", name="taxonomyrelation_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Taxonomyrelation:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomyrelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomyrelation entity.');
        }

        $editForm   = $this->createForm(new TaxonomyrelationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taxonomyrelation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Taxonomyrelation entity.
     *
     * @Route("/{id}/delete", name="taxonomyrelation_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Taxonomyrelation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Taxonomyrelation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('taxonomyrelation'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
