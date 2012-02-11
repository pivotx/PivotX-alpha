<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Extrafield;
use PivotX\CoreBundle\Form\ExtrafieldType;

/**
 * Extrafield controller.
 *
 * @Route("/extrafield")
 */
class ExtrafieldController extends Controller
{
    /**
     * Lists all Extrafield entities.
     *
     * @Route("/", name="extrafield")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Extrafield')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Extrafield entity.
     *
     * @Route("/{id}/show", name="extrafield_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Extrafield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Extrafield entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Extrafield entity.
     *
     * @Route("/new", name="extrafield_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Extrafield();
        $form   = $this->createForm(new ExtrafieldType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Extrafield entity.
     *
     * @Route("/create", name="extrafield_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Extrafield:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Extrafield();
        $request = $this->getRequest();
        $form    = $this->createForm(new ExtrafieldType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('extrafield_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Extrafield entity.
     *
     * @Route("/{id}/edit", name="extrafield_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Extrafield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Extrafield entity.');
        }

        $editForm = $this->createForm(new ExtrafieldType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Extrafield entity.
     *
     * @Route("/{id}/update", name="extrafield_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Extrafield:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Extrafield')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Extrafield entity.');
        }

        $editForm   = $this->createForm(new ExtrafieldType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('extrafield_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Extrafield entity.
     *
     * @Route("/{id}/delete", name="extrafield_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Extrafield')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Extrafield entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('extrafield'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
