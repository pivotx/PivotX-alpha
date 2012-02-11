<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Mediarelation;
use PivotX\CoreBundle\Form\MediarelationType;

/**
 * Mediarelation controller.
 *
 * @Route("/mediarelation")
 */
class MediarelationController extends Controller
{
    /**
     * Lists all Mediarelation entities.
     *
     * @Route("/", name="mediarelation")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Mediarelation')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Mediarelation entity.
     *
     * @Route("/{id}/show", name="mediarelation_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Mediarelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mediarelation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Mediarelation entity.
     *
     * @Route("/new", name="mediarelation_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mediarelation();
        $form   = $this->createForm(new MediarelationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Mediarelation entity.
     *
     * @Route("/create", name="mediarelation_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Mediarelation:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Mediarelation();
        $request = $this->getRequest();
        $form    = $this->createForm(new MediarelationType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mediarelation_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Mediarelation entity.
     *
     * @Route("/{id}/edit", name="mediarelation_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Mediarelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mediarelation entity.');
        }

        $editForm = $this->createForm(new MediarelationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Mediarelation entity.
     *
     * @Route("/{id}/update", name="mediarelation_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Mediarelation:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Mediarelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mediarelation entity.');
        }

        $editForm   = $this->createForm(new MediarelationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mediarelation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Mediarelation entity.
     *
     * @Route("/{id}/delete", name="mediarelation_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Mediarelation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mediarelation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mediarelation'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
