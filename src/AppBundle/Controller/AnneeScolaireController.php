<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnneeScolaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Anneescolaire controller.
 *
 * @Route("annee_scolaire")
 */
class AnneeScolaireController extends Controller
{
    /**
     * Lists all anneeScolaire entities.
     *
     * @Route("/", name="annee_scolaire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $anneeScolaires = $em->getRepository('AppBundle:AnneeScolaire')->findAll();

        return $this->render('@App/anneescolaire/index.html.twig', array(
            'anneeScolaires' => $anneeScolaires,
        ));
    }

    /**
     * Creates a new anneeScolaire entity.
     *
     * @Route("/new", name="annee_scolaire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $anneeScolaire = new Anneescolaire();
        $form = $this->createForm('AppBundle\Form\AnneeScolaireType', $anneeScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anneeScolaire);
            $em->flush();

            return $this->redirectToRoute('annee_scolaire_show', array('id' => $anneeScolaire->getId()));
        }

        return $this->render('@App/anneescolaire/new.html.twig', array(
            'anneeScolaire' => $anneeScolaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a anneeScolaire entity.
     *
     * @Route("/{id}", name="annee_scolaire_show")
     * @Method("GET")
     */
    public function showAction(AnneeScolaire $anneeScolaire)
    {
        $deleteForm = $this->createDeleteForm($anneeScolaire);

        return $this->render('@App/anneescolaire/show.html.twig', array(
            'anneeScolaire' => $anneeScolaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing anneeScolaire entity.
     *
     * @Route("/{id}/edit", name="annee_scolaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnneeScolaire $anneeScolaire)
    {
        $deleteForm = $this->createDeleteForm($anneeScolaire);
        $editForm = $this->createForm('AppBundle\Form\AnneeScolaireType', $anneeScolaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annee_scolaire_edit', array('id' => $anneeScolaire->getId()));
        }

        return $this->render('@App/anneescolaire/edit.html.twig', array(
            'anneeScolaire' => $anneeScolaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a anneeScolaire entity.
     *
     * @Route("/{id}", name="annee_scolaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnneeScolaire $anneeScolaire)
    {
        $form = $this->createDeleteForm($anneeScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anneeScolaire);
            $em->flush();
        }

        return $this->redirectToRoute('annee_scolaire_index');
    }

    /**
     * Creates a form to delete a anneeScolaire entity.
     *
     * @param AnneeScolaire $anneeScolaire The anneeScolaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnneeScolaire $anneeScolaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annee_scolaire_delete', array('id' => $anneeScolaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
