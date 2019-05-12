<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\CompteBanque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Comptebanque controller.
 *
 * @Route("compte_banque")
 */
class CompteBanqueController extends MainController
{
    
    // Menu vertical pour les sorties 
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Opérations Du Jour", "id"=>"", "href"=> $this->generateUrl("operation_banque_index")),
           array("libelle"=>"Nouvelle Opération", "id"=>"", "href"=>$this->generateUrl("operation_banque_new")),
           array("libelle"=>"Recherche Opération", "id"=>"", "href"=>$this->generateUrl("sortie_search_index")),
           array("libelle"=>"Plus", "id"=>"", "href"=>"#", "dropdown"=>array(array(
                                                        "href"=>$this->generateUrl("compte_banque_new"), "libelle"=>"Créer Nouveau Compte"),
                                                        array("href"=>$this->generateUrl("compte_banque_index"), "libelle"=>"Liste Des Comptes",
                                                                                ))),
            );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all compteBanque entities.
     *
     * @Route("/", name="compte_banque_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();

        $compteBanques = $em->getRepository('GOCaisseBundle:CompteBanque')->findAll();

        return $this->render('@GOCaisse/comptebanque/index.html.twig', array(
            'compteBanques' => $compteBanques,
        ));
    }

    /**
     * Creates a new compteBanque entity.
     *
     * @Route("/nouveau", name="compte_banque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $compteBanque = new CompteBanque();
        $form = $this->createForm('GO\CaisseBundle\Form\CompteBanqueType', $compteBanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($compteBanque);
            $em->flush();

            return $this->redirectToRoute('compte_banque_show', array('id' => $compteBanque->getId()));
        }

        return $this->render('@GOCaisse/comptebanque/new.html.twig', array(
            'compteBanque' => $compteBanque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a compteBanque entity.
     *
     * @Route("/{id}/afficher", name="compte_banque_show")
     * @Method("GET")
     */
    public function showAction(CompteBanque $compteBanque)
    {
        $deleteForm = $this->createDeleteForm($compteBanque);

        return $this->render('@GOCaisse/comptebanque/show.html.twig', array(
            'compteBanque' => $compteBanque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing compteBanque entity.
     *
     * @Route("/{id}/edit", name="compte_banque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CompteBanque $compteBanque)
    {
        $deleteForm = $this->createDeleteForm($compteBanque);
        $editForm = $this->createForm('GO\CaisseBundle\Form\CompteBanqueType', $compteBanque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compte_banque_edit', array('id' => $compteBanque->getId()));
        }

        return $this->render('@GOCaisse/comptebanque/edit.html.twig', array(
            'compteBanque' => $compteBanque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a compteBanque entity.
     *
     * @Route("/{id}/supprimer", name="compte_banque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CompteBanque $compteBanque)
    {
        $form = $this->createDeleteForm($compteBanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($compteBanque);
            $em->flush();
            $this->addFlash("success", "Compte Supprimé avec Succès!");
        }

        return $this->redirectToRoute('compte_banque_index');
    }

    /**
     * Creates a form to delete a compteBanque entity.
     *
     * @param CompteBanque $compteBanque The compteBanque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CompteBanque $compteBanque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compte_banque_delete', array('id' => $compteBanque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
