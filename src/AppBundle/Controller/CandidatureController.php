<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Candidature;
use AppBundle\Entity\Dossier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Candidature controller.
 *
 * @Route("candidature")
 */
class CandidatureController extends Controller
{
    /**
     * Lists all candidature entities.
     *
     * @Route("/", name="candidature_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidatures = $em->getRepository('AppBundle:Candidature')->findAll();

        return $this->render('@App/candidature/index.html.twig', array(
            'candidatures' => $candidatures,
        ));
    }

    /**
     * Creates a new candidature entity.
     *
     * @Route("/new/dossier/{id}", name="candidature_new")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_GP')")
     */
    public function newAction(Request $request, Dossier $dossier)
    {
        $candidature = new Candidature();
        $candidature->setDossier($dossier);
        $candidature->setUser($this->getUser());
        $form = $this->createForm('AppBundle\Form\CandidatureType', $candidature);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();

            return $this->redirectToRoute('candidature_show', array('id' => $candidature->getId()));
        }

        return $this->render('@App/candidature/new.html.twig', array(
            'candidature' => $candidature,
            'form' => $form->createView(),
            'dossier' => $dossier,
        ));
    }

    /**
     * Finds and displays a candidature entity.
     *
     * @Route("/{id}", name="candidature_show")
     * @Method("GET")
     * @Secure("has_role('ROLE_GP')")
     */
    public function showAction(Candidature $candidature)
    {
        $deleteForm = $this->createDeleteForm($candidature);

        return $this->render('@App/candidature/show.html.twig', array(
            'candidature' => $candidature,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing candidature entity.
     *
     * @Route("/{id}/edit", name="candidature_edit")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function editAction(Request $request, Candidature $candidature)
    {
        $deleteForm = $this->createDeleteForm($candidature);
        $editForm = $this->createForm('AppBundle\Form\CandidatureType', $candidature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidature_edit', array('id' => $candidature->getId()));
        }

        return $this->render('@App/candidature/edit.html.twig', array(
            'candidature' => $candidature,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a candidature entity.
     *
     * @Route("/{id}", name="candidature_delete")
     * @Method("DELETE")
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function deleteAction(Request $request, Candidature $candidature)
    {
        $form = $this->createDeleteForm($candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($candidature);
            $em->flush();
        }

        return $this->redirectToRoute('candidature_index');
    }

    /**
     * Creates a form to delete a candidature entity.
     *
     * @param Candidature $candidature The candidature entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Candidature $candidature)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('candidature_delete', array('id' => $candidature->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
