<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Response;
use PivotX\CoreBundle\Form\ResponseType;

/**
 * Response controller.
 *
 * @Route("/response")
 */
class ResponseController extends Controller
{
    /**
     * Lists all Response entities.
     *
     * @Route("/", name="response")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Response')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Response entity.
     *
     * @Route("/{id}/show", name="response_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Response')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Response entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Response entity.
     *
     * @Route("/new", name="response_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Response();
        $form   = $this->createForm(new ResponseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Response entity.
     *
     * @Route("/create", name="response_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Response:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Response();
        $request = $this->getRequest();
        $form    = $this->createForm(new ResponseType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('response_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Response entity.
     *
     * @Route("/{id}/edit", name="response_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Response')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Response entity.');
        }

        $editForm = $this->createForm(new ResponseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Response entity.
     *
     * @Route("/{id}/update", name="response_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Response:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Response')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Response entity.');
        }

        $editForm   = $this->createForm(new ResponseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('response_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Response entity.
     *
     * @Route("/{id}/delete", name="response_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Response')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Response entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('response'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
