<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Permission;
use PivotX\CoreBundle\Form\PermissionType;

/**
 * Permission controller.
 *
 * @Route("/permission")
 */
class PermissionController extends Controller
{
    /**
     * Lists all Permission entities.
     *
     * @Route("/", name="permission")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Permission')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Permission entity.
     *
     * @Route("/{id}/show", name="permission_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Permission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Permission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Permission entity.
     *
     * @Route("/new", name="permission_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Permission();
        $form   = $this->createForm(new PermissionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Permission entity.
     *
     * @Route("/create", name="permission_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Permission:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Permission();
        $request = $this->getRequest();
        $form    = $this->createForm(new PermissionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('permission_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Permission entity.
     *
     * @Route("/{id}/edit", name="permission_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Permission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Permission entity.');
        }

        $editForm = $this->createForm(new PermissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Permission entity.
     *
     * @Route("/{id}/update", name="permission_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Permission:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Permission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Permission entity.');
        }

        $editForm   = $this->createForm(new PermissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('permission_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Permission entity.
     *
     * @Route("/{id}/delete", name="permission_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Permission')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Permission entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('permission'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
