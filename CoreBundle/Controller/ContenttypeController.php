<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Contenttype;
use PivotX\CoreBundle\Form\ContenttypeType;

/**
 * Contenttype controller.
 *
 * @Route("/contenttype")
 */
class ContenttypeController extends Controller
{
    /**
     * Lists all Contenttype entities.
     *
     * @Route("/", name="contenttype")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Contenttype')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Contenttype entity.
     *
     * @Route("/{id}/show", name="contenttype_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Contenttype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenttype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Contenttype entity.
     *
     * @Route("/new", name="contenttype_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contenttype();
        $form   = $this->createForm(new ContenttypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Contenttype entity.
     *
     * @Route("/create", name="contenttype_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Contenttype:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Contenttype();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContenttypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenttype_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Contenttype entity.
     *
     * @Route("/{id}/edit", name="contenttype_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Contenttype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenttype entity.');
        }

        $editForm = $this->createForm(new ContenttypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Contenttype entity.
     *
     * @Route("/{id}/update", name="contenttype_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Contenttype:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Contenttype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenttype entity.');
        }

        $editForm   = $this->createForm(new ContenttypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenttype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Contenttype entity.
     *
     * @Route("/{id}/delete", name="contenttype_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Contenttype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contenttype entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contenttype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
