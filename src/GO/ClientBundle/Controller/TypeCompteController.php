<?php

namespace GO\ClientBundle\Controller;

use GO\ClientBundle\Entity\TypeCompte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typecompte controller.
 *
 * @Route("type_compte")
 */
class TypeCompteController extends Controller
{
    /**
     * Lists all typeCompte entities.
     *
     * @Route("/", name="type_compte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeComptes = $em->getRepository('GOClientBundle:TypeCompte')->findAll();

        return $this->render('@GOClient/type_compte/index.html.twig', array(
            'typeComptes' => $typeComptes,
        ));
    }

    /**
     * Creates a new typeCompte entity.
     *
     * @Route("/new", name="type_compte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeCompte = new Typecompte();
        $form = $this->createForm('GO\ClientBundle\Form\TypeCompteType', $typeCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCompte);
            $em->flush();

            return $this->redirectToRoute('type_compte_show', array('id' => $typeCompte->getId()));
        }

        return $this->render('@GOClient/type_compte/new.html.twig', array(
            'typeCompte' => $typeCompte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeCompte entity.
     *
     * @Route("/{id}", name="type_compte_show")
     * @Method("GET")
     */
    public function showAction(TypeCompte $typeCompte)
    {
        $deleteForm = $this->createDeleteForm($typeCompte);

        return $this->render('@GOClient/type_compte/show.html.twig', array(
            'typeCompte' => $typeCompte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeCompte entity.
     *
     * @Route("/{id}/edit", name="type_compte_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeCompte $typeCompte)
    {
        $deleteForm = $this->createDeleteForm($typeCompte);
        $editForm = $this->createForm('GO\ClientBundle\Form\TypeCompteType', $typeCompte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_compte_edit', array('id' => $typeCompte->getId()));
        }

        return $this->render('@GOClient/type_compte/edit.html.twig', array(
            'typeCompte' => $typeCompte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeCompte entity.
     *
     * @Route("/{id}", name="type_compte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeCompte $typeCompte)
    {
        $form = $this->createDeleteForm($typeCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeCompte);
            $em->flush();
        }

        return $this->redirectToRoute('type_compte_index');
    }

    /**
     * Creates a form to delete a typeCompte entity.
     *
     * @param TypeCompte $typeCompte The typeCompte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeCompte $typeCompte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_compte_delete', array('id' => $typeCompte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
