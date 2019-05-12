<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\Entree;
use GO\CaisseBundle\Entity\HistoCaisse;
use GO\CaisseBundle\Form\EntreeSearchType;
use GO\GOLibrary\Utils\DateConstants as Cons;
use GO\CaisseBundle\Entity\AbstractTypeOperation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Entree controller.
 *
 * @Route("entree")
 */
class EntreeController extends MainController
{
    // Menu vertical pour les entree
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Nouvelle Entrée", "id"=>"", "href"=> $this->generateUrl("entree_new")),
           array("libelle"=>"Entrée du Jour", "id"=>"", "href"=>$this->generateUrl("entree_index")),
           array("libelle"=>"Recherche Entrée", "id"=>"", "href"=>$this->generateUrl("entree_search_index")),
            array("libelle"=>"Plus", "id"=>"", "href"=>"#", "dropdown"=>array(array(
                                                        "href"=>$this->generateUrl("type_entree_new"), "libelle"=>"Créer Type Entrée"),
                                                        array("href"=>$this->generateUrl("type_entree_index"), "libelle"=>"Liste Type Entrée",
                                                                                ))),
            );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all entree entities.
     *
     * @Route("/", name="entree_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();

        $entrees = $em->getRepository('GOCaisseBundle:Entree')->findAll();

        return $this->render('@GOCaisse/entree/index.html.twig', array(
            'entrees' => $entrees,
        ));
    }

    /**
     * Creates a new entree entity.
     *
     * @Route("/new", name="entree_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entree = new Entree();
        $form = $this->createForm('GO\CaisseBundle\Form\EntreeType', $entree,array('session'=>$this->get("session")));
        $form->handleRequest($request);
        $entree->setDate(new \DateTime());
        
        if ($form->isSubmitted() && $form->isValid()) {
            $caisse=$entree->getCaisse();
            // cette classe permet d'entregistrer l'opération entrée dans l'historique des opérations de caisse
            $HistoCaisse = new HistoCaisse();
            // Le solde avant opération et le solde après opération sont archivés ainsi que l'heure de l'opétation
            $HistoCaisse->setMontant($entree->getMontant())
                        ->setAncienSolde($caisse->getSolde())
                        ->setNouveauSolde($caisse->getSolde()+$entree->getMontant())
                        ->setCaisse($caisse)
                        ->setTypeOp(AbstractTypeOperation::ENTREE_LIQUIDE)
                        ->setDateOp($entree->getDate())
                        ->setEntree($entree)
                        ->setUser($this->getUser());
                        
            $caisse->setSolde($caisse->getSolde()+$entree->getMontant());
            // On récupère l'entité boutique qui permet de préciser l'opération
            $em = $this->getDoctrine()->getManager();
            $em->persist($entree);
            $em->persist($caisse);
            $em->persist($HistoCaisse);
            $em->flush();

            return $this->redirectToRoute('entree_show', array('id' => $entree->getId()));
        }

        return $this->render('@GOCaisse/entree/new.html.twig', array(
            'entree' => $entree,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a entree entity.
     *
     * @Route("/{id}", name="entree_show")
     * @Method("GET")
     */
    public function showAction(Entree $entree)
    {
        $deleteForm = $this->createDeleteForm($entree);

        return $this->render('@GOCaisse/entree/show.html.twig', array(
            'entree' => $entree,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entree entity.
     *
     * @Route("/{id}/modifier", name="entree_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entree $entree)
    {
        $deleteForm = $this->createDeleteForm($entree);
        $editForm = $this->createForm('GO\CaisseBundle\Form\EntreeType', $entree,array('session'=>$this->get("session")));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entree_edit', array('id' => $entree->getId()));
        }

        return $this->render('@GOCaisse/entree/edit.html.twig', array(
            'entree' => $entree,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a entree entity.
     *
     * @Route("/delete/{id}", name="entree_delete")
     */
    public function deleteAction(Request $request, Entree $entree)
    {
        $form = $this->createDeleteForm($entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $histoEntry=$em->getRepository("GOCaisseBundle:HistoCaisse")->findOneByEntree($entree->getId());
            if(!is_null($histoEntry))
            {
            $histoEntry->setDeleted(true)->setDeletedAt(new \DateTime())->setEntree(null);
            $em->persist($histoEntry);
            }
            $em->remove($entree);
            $em->flush();
        }

        return $this->redirectToRoute('entree_index');
    }

    /**
     * Creates a form to delete a entree entity.
     *
     * @param Entree $entree The entree entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entree $entree)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entree_delete', array('id' => $entree->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * 
     * @return type
     * @Route("/recherche/", name="entree_search_index")
     */
    public function entreeSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm('GO\CaisseBundle\Form\EntreeSearchType',$data);
         return $this->render('@GOCaisse/entree/search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/search/get_result", name="caisse_pro_entree_search")
     */
public function entreeSearchAction(Request $req)
    {
       
        $em=$this->getDoctrine()->getManager();
        $entreeRepo=$em->getRepository('GOCaisseBundle:Entree');
        $liste= null;
        $entrees=null;
        $total_entree=null;
        $total_benefice=null;
        $form=$this->createForm("GO\CaisseBundle\Form\EntreeSearchType", array());
        $form->bind($req);
        $caisse= $this->getActiveCaisse();
         $totaux_poste_dep=array();
         
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);
        switch ($data['type_search'])
        {
            case 'total': $total_entree=$entreeRepo->getTotalEntree($caisse,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
                break;
            case 'liste': $entrees=$entreeRepo->getListeEntree($caisse,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
            $total_entree=$entreeRepo->getTotalEntree($caisse,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
            break;
        
            case 'poste_depense':
                $type=$this->getRepo('Charge')->find(3);
                $entrees=$entreeRepo->getListeTypeEntree($caisse, $type,Cons::DATE_INTERVALLE,$data['date_debut'], $data['date_fin']);
            
            break;  
         }       $postDepRepo=$em->getRepository('GOCaisseBundle:TypeEntree');
        $posteDepenes=$postDepRepo->findAll();
       
        foreach($posteDepenes as $posteDep)
        {
            $tot=array("montant"=>$entreeRepo->getTotalEntreeType($caisse,$posteDep,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']),
                    "libelle"=>$posteDep->getLibelle());
                array_push($totaux_poste_dep, $tot);
        }
             
            
        
        
            }
        return $this->render('@GOCaisse/entree/liste.html.twig', array('entrees'=>$entrees, 
            'total_entree'=>$total_entree,
                "total_postes"=>$totaux_poste_dep));
   
       }
}
