<?php

namespace GO\SMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GO\SMSBundle\Entity\PayerAbonnement;
use GO\SMSBundle\Form\PayerAbonnementType;

/**
 * PayerAbonnement controller.
 *
 * @Route("/payer_abonnement")
 */
class PayerAbonnementController extends Controller
{
    /**
     * Lists all PayerAbonnement entities.
     *
     * @Route("/", name="payer_abonnement")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GOSMSBundle:PayerAbonnement')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new PayerAbonnement entity.
     *
     * @Route("/", name="payer_abonnement_create")
     * @Method("POST")
     * @Template("GOSMSBundle:PayerAbonnement:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new PayerAbonnement();
        $form = $this->createForm(new PayerAbonnementType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('payer_abonnement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new PayerAbonnement entity.
     *
     * @Route("/new", name="payer_abonnement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PayerAbonnement();
        $form   = $this->createForm(new PayerAbonnementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PayerAbonnement entity.
     *
     * @Route("/{id}", name="payer_abonnement_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GOSMSBundle:PayerAbonnement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PayerAbonnement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PayerAbonnement entity.
     *
     * @Route("/{id}/edit", name="payer_abonnement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GOSMSBundle:PayerAbonnement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PayerAbonnement entity.');
        }

        $editForm = $this->createForm(new PayerAbonnementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing PayerAbonnement entity.
     *
     * @Route("/{id}", name="payer_abonnement_update")
     * @Method("PUT")
     * @Template("GOSMSBundle:PayerAbonnement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GOSMSBundle:PayerAbonnement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PayerAbonnement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PayerAbonnementType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('payer_abonnement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PayerAbonnement entity.
     *
     * @Route("/{id}", name="payer_abonnement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GOSMSBundle:PayerAbonnement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PayerAbonnement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('payer_abonnement'));
    }

    /**
     * Creates a form to delete a PayerAbonnement entity by id.
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
