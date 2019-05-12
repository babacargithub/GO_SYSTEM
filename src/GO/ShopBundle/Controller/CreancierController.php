<?php

namespace GO\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GO\ShopBundle\Entity\Creancier;
use GO\ShopBundle\Form\CreancierType;

/**
 * Creancier controller.
 *
 * @Route("/shop")
 */
class CreancierController extends Controller
{
    /**
     * Lists all Creancier entities.
     *
     * @Route("/", name="shop")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GOShopBundle:Creancier')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Creancier entity.
     *
     * @Route("/", name="shop_create")
     * @Method("POST")
     * @Template("GOShopBundle:Creancier:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Creancier();
        $form = $this->createForm(new CreancierType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shop_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Creancier entity.
     *
     * @Route("/new", name="shop_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Creancier();
        $form   = $this->createForm(new CreancierType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Creancier entity.
     *
     * @Route("/{id}", name="shop_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GOShopBundle:Creancier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Creancier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Creancier entity.
     *
     * @Route("/{id}/edit", name="shop_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GOShopBundle:Creancier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Creancier entity.');
        }

        $editForm = $this->createForm(new CreancierType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Creancier entity.
     *
     * @Route("/{id}", name="shop_update")
     * @Method("PUT")
     * @Template("GOShopBundle:Creancier:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GOShopBundle:Creancier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Creancier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CreancierType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shop_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Creancier entity.
     *
     * @Route("/{id}", name="shop_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GOShopBundle:Creancier')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Creancier entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('shop'));
    }

    /**
     * Creates a form to delete a Creancier entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
