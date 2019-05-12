<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\OpBanque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Opbanque controller.
 *
 * @Route("operation_banque")
 */
class OpBanqueController extends MainController
{
    /**
     * Lists all opBanque entities.
     *
     * @Route("/", name="operation_banque_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();

        $opBanques = $em->getRepository('GOCaisseBundle:OpBanque')->findAll();

        return $this->render('@GOCaisse/opbanque/index.html.twig', array(
            'opBanques' => $opBanques,
        ));
    }

    /**
     * Creates a new opBanque entity.
     *
     * @Route("/new", name="operation_banque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $opBanque = new OpBanque();
        $form = $this->createForm('GO\CaisseBundle\Form\OpBanqueType', $opBanque, array("session"=> $this->get('session')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compteBanqueOperation=$opBanque->getCompte();
            $caisseOperation=$this->getActiveCaisse();
            $opBanque->setUser($this->getUser());
            $opBanque->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($opBanque);
            //modifier le solde de la caisse en fonction de l'opération. les oprérations en entrant augmentent la caisse, les opérations diminue
            switch($opBanque->getTypeOp())
            {
                case OpBanque::VERSEMENT:
                $compteBanqueOperation->augmenterSolde($opBanque->getMontant());
                $caisseOperation->diminuerSolde($opBanque->getMontant());
                break;
                case OpBanque::RETRAIT:
                $compteBanqueOperation->diminuerSolde($opBanque->getMontant());
                $caisseOperation->augmenterSolde($opBanque->getMontant());
                break;
                case OpBanque::VIREMENT_RECU:
                $compteBanqueOperation->augmenterSolde($opBanque->getMontant());
                break;
                case OpBanque::VIREMENT_EMIS:
                $compteBanqueOperation->diminuerSolde($opBanque->getMontant());
                break;
              
            }
            $em->persist($compteBanqueOperation);
            $em->persist($caisseOperation);
            $em->flush();

            return $this->redirectToRoute('operation_banque_show', array('id' => $opBanque->getId()));
        }

        return $this->render('@GOCaisse/opbanque/new.html.twig', array(
            'opBanque' => $opBanque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a opBanque entity.
     *
     * @Route("/{id}", name="operation_banque_show")
     * @Method("GET")
     */
    public function showAction(OpBanque $opBanque)
    {
        $deleteForm = $this->createDeleteForm($opBanque);

        return $this->render('@GOCaisse/opbanque/show.html.twig', array(
            'opBanque' => $opBanque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing opBanque entity.
     *
     * @Route("/{id}/edit", name="operation_banque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OpBanque $opBanque)
    {
        $deleteForm = $this->createDeleteForm($opBanque);
        $editForm = $this->createForm('GO\CaisseBundle\Form\OpBanqueType', $opBanque,array("session"=> $this->get('session')));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operation_banque_edit', array('id' => $opBanque->getId()));
        }

        return $this->render('@GOCaisse/opbanque/edit.html.twig', array(
            'opBanque' => $opBanque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a opBanque entity.
     *
     * @Route("/{id}", name="operation_banque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OpBanque $opBanque)
    {
        $form = $this->createDeleteForm($opBanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($opBanque);
            $em->flush();
        }

        return $this->redirectToRoute('operation_banque_index');
    }

    /**
     * Creates a form to delete a opBanque entity.
     *
     * @param OpBanque $opBanque The opBanque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OpBanque $opBanque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operation_banque_delete', array('id' => $opBanque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
