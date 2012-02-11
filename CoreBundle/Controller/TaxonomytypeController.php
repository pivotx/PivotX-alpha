<?php

namespace PivotX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PivotX\CoreBundle\Entity\Taxonomytype;
use PivotX\CoreBundle\Form\TaxonomytypeType;

/**
 * Taxonomytype controller.
 *
 * @Route("/taxonomytype")
 */
class TaxonomytypeController extends Controller
{
    /**
     * Lists all Taxonomytype entities.
     *
     * @Route("/", name="taxonomytype")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PivotXCoreBundle:Taxonomytype')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Taxonomytype entity.
     *
     * @Route("/{id}/show", name="taxonomytype_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomytype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomytype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Taxonomytype entity.
     *
     * @Route("/new", name="taxonomytype_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Taxonomytype();
        $form   = $this->createForm(new TaxonomytypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Taxonomytype entity.
     *
     * @Route("/create", name="taxonomytype_create")
     * @Method("post")
     * @Template("PivotXCoreBundle:Taxonomytype:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Taxonomytype();
        $request = $this->getRequest();
        $form    = $this->createForm(new TaxonomytypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taxonomytype_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Taxonomytype entity.
     *
     * @Route("/{id}/edit", name="taxonomytype_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomytype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomytype entity.');
        }

        $editForm = $this->createForm(new TaxonomytypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Taxonomytype entity.
     *
     * @Route("/{id}/update", name="taxonomytype_update")
     * @Method("post")
     * @Template("PivotXCoreBundle:Taxonomytype:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PivotXCoreBundle:Taxonomytype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taxonomytype entity.');
        }

        $editForm   = $this->createForm(new TaxonomytypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taxonomytype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Taxonomytype entity.
     *
     * @Route("/{id}/delete", name="taxonomytype_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PivotXCoreBundle:Taxonomytype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Taxonomytype entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('taxonomytype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
