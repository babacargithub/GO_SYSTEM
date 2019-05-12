<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Paiement;
use AppBundle\Entity\Dossier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Secure;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paiement controller.
 *
 * @Route("paiement")
 */
class PaiementController extends Controller
{
    
    public function menuVerticalAction()
    {
        $menus=array(
            //array("href"=> $this->generateUrl("paiement_summary"), "libelle"=>"Voir résumé"),
            array("href"=> $this->generateUrl("exercice_chiffres", array('id'=>$this->getDoctrine()->getManager()->getRepository('AppBundle:Exercice')->getCurrent()->getId()
      )), "libelle"=>"Les Chiffres"),
        );
        return $this->render('@App/paiement/menu_vertical.html.twig', array("menus"=>$menus));
    } 
    /**
     * Lists all paiement entities.
     *
     * @Route("/", name="paiement_index")
     * @Method("GET")
     * @Secure("has_role('ROLE_DG')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paiements = $em->getRepository('AppBundle:Paiement')->findAll();
        $dossiers = $em->getRepository('AppBundle:Dossier')->findAll();
        return $this->render('@App/paiement/index.html.twig', array(
            'paiements' => $paiements,
            'dossiers' => $dossiers,
        ));
    }

    /**
     * Creates a new paiement entity.
     *
     * @Route("/new/dossier/{id}", name="paiement_new")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_GP')")
     */
    public function newAction(Request $request, Dossier $dossier)
    {
        $paiement = new Paiement();
        $paiement->setDossier($dossier);
        $paiement->setUser($this->getUser());
        $paiement->setNumFacture($dossier->getNum().''.Date('i'));
        $form = $this->createForm('AppBundle\Form\PaiementType', $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paiement);
            $em->flush();

            return $this->redirectToRoute('paiement_show', array('id' => $paiement->getId()));
        }

        return $this->render('@App/paiement/new.html.twig', array(
            'paiement' => $paiement,
            'form' => $form->createView(),
            'dossier' => $dossier,
        ));
    }

    /**
     * Finds and displays a paiement entity.
     *
     * @Route("/{id}", name="paiement_show")
     * @Method("GET")
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function showAction(Paiement $paiement)
    {
        $deleteForm = $this->createDeleteForm($paiement);

        return $this->render('@App/paiement/show.html.twig', array(
            'paiement' => $paiement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paiement entity.
     *
     * @Route("/{id}/edit", name="paiement_edit")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_DIR_AG')")
     */
    public function editAction(Request $request, Paiement $paiement)
    {
        $deleteForm = $this->createDeleteForm($paiement);
        $editForm = $this->createForm('AppBundle\Form\PaiementType', $paiement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_edit', array('id' => $paiement->getId()));
        }

        return $this->render('@App/paiement/edit.html.twig', array(
            'paiement' => $paiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paiement entity.
     *
     * @Route("/delete/{id}", name="paiement_delete")
     * @Secure("has_role('ROLE_DG')")
     
     */
    public function deleteAction(Request $request, Paiement $paiement)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($paiement);
            $em->flush();
        

        return $this->redirectToRoute('paiement_index');
    }

    /**
     * Creates a form to delete a paiement entity.
     *
     * @param Paiement $paiement The paiement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paiement $paiement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paiement_delete', array('id' => $paiement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
