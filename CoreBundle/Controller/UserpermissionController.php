<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Userpermission;
use PivotX\CoreBundle\Form\UserpermissionType;

/**
 * Userpermission controller.
 *
 * @Route("/userpermission")
 */
class UserpermissionController extends Controller
{
    /**
     * Lists all Userpermission entities.
     *
     * @Route("/", name="userpermission")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Userpermission')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Userpermission entity.
     *
     * @Route("/{id}/show", name="userpermission_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Userpermission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Userpermission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Userpermission entity.
     *
     * @Route("/new", name="userpermission_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Userpermission();
        $form   = $this->createForm(new UserpermissionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Userpermission entity.
     *
     * @Route("/create", name="userpermission_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Userpermission:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Userpermission();
        $request = $this->getRequest();
        $form    = $this->createForm(new UserpermissionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('userpermission_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Userpermission entity.
     *
     * @Route("/{id}/edit", name="userpermission_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Userpermission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Userpermission entity.');
        }

        $editForm = $this->createForm(new UserpermissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Userpermission entity.
     *
     * @Route("/{id}/update", name="userpermission_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Userpermission:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Userpermission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Userpermission entity.');
        }

        $editForm   = $this->createForm(new UserpermissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('userpermission_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Userpermission entity.
     *
     * @Route("/{id}/delete", name="userpermission_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Userpermission')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Userpermission entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('userpermission'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
