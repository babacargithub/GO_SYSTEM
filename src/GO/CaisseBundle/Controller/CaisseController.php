<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\AbstractCaisse;
use GO\CaisseBundle\Entity\Caisse;
use GO\CaisseBundle\Entity\HistoCaisse;
use GO\GOLibrary\Utils\DateConstants as DateCons;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Caisse controller.
 *
 * @Route("caisse_pro")
 */
class CaisseController extends MainController
{
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Opérations Du Jour", "id"=>"", "href"=> $this->generateUrl("histo_today")),
           array("libelle"=>"Créer Nouvelle Caisse", "id"=>"", "href"=>$this->generateUrl("caisse_pro_new")),
           array("libelle"=>"Liste Caisses", "id"=>"", "href"=>$this->generateUrl("caisse_pro_index")),
            array("libelle"=>"Recherche", "id"=>"", "href"=>$this->generateUrl("caisse_pro_new")),
            array("libelle"=>"Plus", "id"=>"", "href"=>"#", 
            "dropdown"=>array(array("href"=>$this->generateUrl("caissier_new"), "libelle"=>"Créer Nouveau Caissier"),
                              array("href"=>$this->generateUrl("caissier_index"), "libelle"=>"Liste Des Caissiers"),
                              array("href"=>$this->generateUrl("caisse_user_new"), "libelle"=>"Affecter Caissier"),
                              array("href"=>$this->generateUrl("caissier_index"), "libelle"=>"Gestion Affectation")
                              )
                ),
            );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all caisse entities.
     *
     * @Route("/", name="caisse_pro_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();

        $caisses = $em->getRepository('GOCaisseBundle:Caisse')->findAll();

        return $this->render('@GOCaisse/caisse/index.html.twig', array(
            'caisses' => $caisses,
        ));
    }

    /**
     * Creates a new caisse entity.
     *
     * @Route("/new", name="caisse_pro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $caisse = new Caisse();
        $form = $this->createForm('GO\CaisseBundle\Form\CaisseType', $caisse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caisse);
            $em->flush();

            return $this->redirectToRoute('caisse_pro_show', array('id' => $caisse->getId()));
        }

        return $this->render('@GOCaisse/caisse/new.html.twig', array(
            'caisse' => $caisse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a caisse entity.
     *
     * @Route("/{id}", name="caisse_pro_show")
     * @Method("GET")
     */
    public function showAction(Caisse $caisse)
    {
        $deleteForm = $this->createDeleteForm($caisse);

        return $this->render('@GOCaisse/caisse/show.html.twig', array(
            'caisse' => $caisse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing caisse entity.
     *
     * @Route("/{id}/edit", name="caisse_pro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Caisse $caisse)
    {
        $deleteForm = $this->createDeleteForm($caisse);
        $editForm = $this->createForm('GO\CaisseBundle\Form\CaisseType', $caisse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caisse_pro_edit', array('id' => $caisse->getId()));
        }

        return $this->render('@GOCaisse/caisse/edit.html.twig', array(
            'caisse' => $caisse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a caisse entity.
     *
     * @Route("/{id}", name="caisse_pro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Caisse $caisse)
    {
        $form = $this->createDeleteForm($caisse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($caisse);
            $em->flush();
        }

        return $this->redirectToRoute('caisse_pro_index');
    }

    /**
     * Creates a form to delete a caisse entity.
     *
     * @param Caisse $caisse The caisse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Caisse $caisse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('caisse_pro_delete', array('id' => $caisse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * 
     * @param Request $req
     * 
     * @Route("/historique_caisse/", name="histo_today")
     */
    public function getHistoOperation(Request $req)
    {
        $operations=$em= $this->getDoctrine()->getManager()->getRepository("GOCaisseBundle:HistoCaisse")->getListe($this->getActiveCaisse(), DateCons::AUJOURDHUI);
        return $this->render('@GOCaisse/caisse/histo_op.html.twig', array('operations'=>$operations));
        
    }
    /**
     * 
     * @param Request $req
     * 
     * @Route("/resume_caisse/{id}/{date_debut}/{date_fin}", name="summary_caisse", defaults={"date_debut"=null,"date_fin"=null})
     */
    public function getSummary(Caisse $caisse, Request $req)
    {
        $dateDebut=null;
        $dateFin=null;
        if($req->get('date_debut')!="")
            $dateDebut=$req->get('date_debut');
        if($req->get('date_fin')!="")
            $dateFin=$req->get('date_fin');
        $em= $this->getDoctrine()->getManager();
        $dateExploded=explode('-',$dateDebut);
        $dateCalculated="".$dateExploded[0]."-".$dateExploded[1]."-";
        $data=array();
        for($i=1;$i<=intval(Date('d'));$i++)
        { 
            $iDate=$i;
        if($i<=9)
        {
            $iDate="0".$i;
        }
        /*'soldeFinJournee'=>$em->getRepository("GOCaisseBundle:Caisse")->getSolde($caisse,AbstractCaisse::SODLE_FIN_JOUENEE,$dateDebut),
            'soldeDebutJournee'=>$em->getRepository("GOCaisseBundle:Caisse")->getSolde($caisse,AbstractCaisse::SODLE_DEBUT_JOUENEE,$dateDebut),
            */
       
        $newDateCalculated=$dateCalculated."".$iDate;
        $new_data=array("date"=>$newDateCalculated,
            "soldeDebutJournee"=>$em->getRepository('GOCaisseBundle:Caisse')->getSolde($caisse,AbstractCaisse::SODLE_DEBUT_JOUENEE,$newDateCalculated),
            "totalSortie"=>$em->getRepository('GOCaisseBundle:Sortie')->getTotalSortie($caisse, DateCons::DATE_INTERVALLE, $newDateCalculated,$newDateCalculated),
            "totalEntree"=>$em->getRepository('GOCaisseBundle:Entree')->getTotalEntree($caisse, DateCons::DATE_INTERVALLE, $newDateCalculated,$newDateCalculated),
            "soldeFinJournee"=>$em->getRepository('GOCaisseBundle:Caisse')->getSolde($caisse,AbstractCaisse::SODLE_FIN_JOUENEE,$newDateCalculated),
            
            );
        array_push($data, $new_data);
        }
         $totalOperations=$em->getRepository('GOCaisseBundle:Caisse')->getTotauxJourneeSummary($caisse, DateCons::DATE_INTERVALLE, $dateDebut,$dateFin);
       
       return $this->render('@GOCaisse/caisse/resume_caisse.html.twig', array(
            'donnees'=>$data, "caisse"=>$caisse));
        
    }
    /**
     * 
     * @param Request $req
     * 
     * @Route("/releve_caisse/{id}/{date_debut}/{date_fin}", name="releve_caisse", defaults={"date_debut"=null,"date_fin"=null})
     */
    public function getReleve(Caisse $caisse, Request $req)
    {
        $dateDebut=null;
        $dateFin=null;
        if($req->get('date_debut')!="")
            $dateDebut=$req->get('date_debut');
        if($req->get('date_fin')!="")
            $dateFin=$req->get('date_fin');
        $em= $this->getDoctrine()->getManager();
        $operations=$em->getRepository("GOCaisseBundle:Caisse")->getReleve($caisse,DateCons::DATE_INTERVALLE,$dateDebut,$dateFin);
      // $totalSortie=$em->getRepository('GOCaisseBundle:Sortie')->getTotalSortie($caisse, DateCons::DATE_INTERVALLE, $dateDebut,$dateFin);
        return $this->render('@GOCaisse/caisse/releve_caisse.html.twig', array('operations'=>$operations,"caisse"=>$caisse));
        
    }
}
