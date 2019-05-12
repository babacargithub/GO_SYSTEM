<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\TypeSortie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typesortie controller.
 *
 * @Route("type_sortie")
 */
class TypeSortieController extends Controller
{
    /**
     * Lists all typeSortie entities.
     *
     * @Route("/", name="type_sortie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeSorties = $em->getRepository('GOCaisseBundle:TypeSortie')->findAll();

        return $this->render('@GOCaisse/typesortie/index.html.twig', array(
            'typeSorties' => $typeSorties,
        ));
    }

    /**
     * Creates a new typeSortie entity.
     *
     * @Route("/new", name="type_sortie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeSortie = new Typesortie();
        $form = $this->createForm('GO\CaisseBundle\Form\TypeSortieType', $typeSortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeSortie);
            $em->flush();

            return $this->redirectToRoute('type_sortie_show', array('id' => $typeSortie->getId()));
        }

        return $this->render('@GOCaisse/typesortie/new.html.twig', array(
            'typeSortie' => $typeSortie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeSortie entity.
     *
     * @Route("/{id}", name="type_sortie_show")
     * @Method("GET")
     */
    public function showAction(TypeSortie $typeSortie)
    {
        $deleteForm = $this->createDeleteForm($typeSortie);

        return $this->render('@GOCaisse/typesortie/show.html.twig', array(
            'typeSortie' => $typeSortie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeSortie entity.
     *
     * @Route("/{id}/edit", name="type_sortie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeSortie $typeSortie)
    {
        $deleteForm = $this->createDeleteForm($typeSortie);
        $editForm = $this->createForm('GO\CaisseBundle\Form\TypeSortieType', $typeSortie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_sortie_edit', array('id' => $typeSortie->getId()));
        }

        return $this->render('@GOCaisse/typesortie/edit.html.twig', array(
            'typeSortie' => $typeSortie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeSortie entity.
     *
     * @Route("/{id}", name="type_sortie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeSortie $typeSortie)
    {
        $form = $this->createDeleteForm($typeSortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeSortie);
            $em->flush();
        }

        return $this->redirectToRoute('type_sortie_index');
    }

    /**
     * Creates a form to delete a typeSortie entity.
     *
     * @param TypeSortie $typeSortie The typeSortie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeSortie $typeSortie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_sortie_delete', array('id' => $typeSortie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
