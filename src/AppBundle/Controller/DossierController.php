<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dossier;
use AppBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Secure;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dossier controller.
 *
 * @Route("dossier")
 */
class DossierController extends Controller
{
    
     public function menuVerticalAction()
    {
        $menus=array(
            array("href"=> $this->generateUrl("candidat_index"), "libelle"=>"Ajouter Nouveau"),
            array("href"=> $this->generateUrl("dossier_show_all"), "libelle"=>"Listes des Dossiers"),
            array("href"=> $this->generateUrl("dossier_index"), "libelle"=>"Recherche"),
        );
        return $this->render('@App/dossier/menu_vertical.html.twig', array("menus"=>$menus));
    }
    /**
     * Lists all dossier entities.
     *
     * @Route("/", name="dossier_index")
     * @Method("GET")
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dossierRepo= $em->getRepository('AppBundle:Dossier');
/*
        return $this->render('@App/dossier/index.html.twig', array(
            'dossiers' => $dossiers,
        ));*/
        $dossier = new Dossier();
        $data=array();
        $form = $this->createForm('AppBundle\Form\DossierSearchType', $data);
        $form->handleRequest($request);
        $notFound=null;
        if ($form->isSubmitted()){
            $dossier=$dossierRepo->findOneByNum(intval($request->get("appbundle_dossier")['numeroDossier']));
            if(!empty($dossier)&&$dossier!=null)
               return $this->redirectToRoute ("dossier_show",array("id"=>$dossier->getId()));
            else
            $notFound="Dossier Introuvable";
           }

        return $this->render('@App/dossier/index.html.twig', array(
            'dossier' => $dossier,
            'form' => $form->createView(),
            'notFound'=>$notFound
        ));
    }
    /**
     * Lists all dossier entities.
     *
     * @Route("/show_all", name="dossier_show_all")
     * @Method("GET")
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     * 
     */
    public function listeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dossiers = $em->getRepository('AppBundle:Dossier')->findAll();

        return $this->render('@App/dossier/show_all.html.twig', array(
            'dossiers' => $dossiers,
        ));
        
    }

    /**
     * Creates a new dossier entity.
     *
     * @Route("/new/dossier_candidat/{id}", name="dossier_new")
     * @Method({"POST","GET"})
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function newAction(Candidat $candidat,Request $request)
    {
        $dossier = new Dossier();
        $dossier->setUser($this->getUser());
        $dossier->setCandidat($candidat);
        $exercice= $this->getDoctrine()->getManager()->getRepository('AppBundle:Exercice')->getCurrent();
        $dossier->setExercice($exercice);
        $dossier->generateNum();
        $dossier->setCreatedAt(new \DateTime());
        $form = $this->createForm('AppBundle\Form\DossierType', $dossier);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dossier);
            $em->flush();
        
            return $this->redirectToRoute('dossier_show', array('id' => $dossier->getId()));
        }

        return $this->render('@App/dossier/new.html.twig', array(
            'dossier' => $dossier,
            'candidat'=>$candidat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dossier entity.
     *
     * @Route("/{id}", name="dossier_show")
     * @Method("GET")
     * @Secure("has_role('ROLE_GP')")
     */
    public function showAction(Dossier $dossier)
    {
        $deleteForm = $this->createDeleteForm($dossier);

        return $this->render('@App/dossier/show.html.twig', array(
            'dossier' => $dossier,
            'delete_form' => $deleteForm->createView(),
            'candidatureForm'=>'',
            'paiementForm'=>'',
            'paiementsDossier'=> $this->getDoctrine()->getManager()->getRepository('AppBundle:Paiement')->getPaiementsDossier($dossier)
        ));
    }
    /**
     * Finds and displays a dossier entity.
     *
     * @Route("/print/{id}", name="dossier_print")
     * @Method("GET")
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function printAction(Dossier $dossier)
    {
        
        return $this->render('@App/dossier/print.html.twig', array(
            'dossier' => $dossier,
            'candidatureForm'=>'',
            'paiementForm'=>'',
            'paiementsDossier'=> $this->getDoctrine()->getManager()->getRepository('AppBundle:Paiement')->getPaiementsDossier($dossier)
        ));
    }

    /**
     * Displays a form to edit an existing dossier entity.
     *
     * @Route("/{id}/edit", name="dossier_edit")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_DIR_AG')")
     */
    public function editAction(Request $request, Dossier $dossier)
    {
        $deleteForm = $this->createDeleteForm($dossier);
        $editForm = $this->createForm('AppBundle\Form\DossierType', $dossier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dossier_edit', array('id' => $dossier->getId()));
        }

        return $this->render('@App/dossier/edit.html.twig', array(
            'dossier' => $dossier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dossier entity.
     *
     * @Route("/{id}", name="dossier_delete")
     * @Method("DELETE")
     * @Secure("has_role('ROLE_DIR_AG')")
     */
    public function deleteAction(Request $request, Dossier $dossier)
    {
        $form = $this->createDeleteForm($dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dossier);
            $em->flush();
        }

        return $this->redirectToRoute('dossier_index');
    }

    /**
     * Creates a form to delete a dossier entity.
     *
     * @param Dossier $dossier The dossier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dossier $dossier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dossier_delete', array('id' => $dossier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
