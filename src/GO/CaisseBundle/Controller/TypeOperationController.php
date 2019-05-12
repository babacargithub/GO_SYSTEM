<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\TypeOperation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeoperation controller.
 *
 * @Route("type_operation")
 */
class TypeOperationController extends Controller
{
    /**
     * Lists all typeOperation entities.
     *
     * @Route("/", name="type_operation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeOperations = $em->getRepository('GOCaisseBundle:TypeOperation')->findAll();

        return $this->render('@GOCaisse/typeoperation/index.html.twig', array(
            'typeOperations' => $typeOperations,
        ));
    }

    /**
     * Creates a new typeOperation entity.
     *
     * @Route("/new", name="type_operation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeOperation = new Typeoperation();
        $form = $this->createForm('GO\CaisseBundle\Form\TypeOperationType', $typeOperation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeOperation);
            $em->flush();

            return $this->redirectToRoute('type_operation_show', array('id' => $typeOperation->getId()));
        }

        return $this->render('@GOCaisse/typeoperation/new.html.twig', array(
            'typeOperation' => $typeOperation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeOperation entity.
     *
     * @Route("/{id}", name="type_operation_show")
     * @Method("GET")
     */
    public function showAction(TypeOperation $typeOperation)
    {
        $deleteForm = $this->createDeleteForm($typeOperation);

        return $this->render('@GOCaisse/typeoperation/show.html.twig', array(
            'typeOperation' => $typeOperation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeOperation entity.
     *
     * @Route("/{id}/edit", name="type_operation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeOperation $typeOperation)
    {
        $deleteForm = $this->createDeleteForm($typeOperation);
        $editForm = $this->createForm('GO\CaisseBundle\Form\TypeOperationType', $typeOperation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_operation_edit', array('id' => $typeOperation->getId()));
        }

        return $this->render('@GOCaisse/typeoperation/edit.html.twig', array(
            'typeOperation' => $typeOperation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeOperation entity.
     *
     * @Route("/{id}", name="type_operation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeOperation $typeOperation)
    {
        $form = $this->createDeleteForm($typeOperation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeOperation);
            $em->flush();
        }

        return $this->redirectToRoute('type_operation_index');
    }

    /**
     * Creates a form to delete a typeOperation entity.
     *
     * @param TypeOperation $typeOperation The typeOperation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeOperation $typeOperation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_operation_delete', array('id' => $typeOperation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
