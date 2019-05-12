<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\Sortie;
use GO\CaisseBundle\Entity\HistoCaisse;
use GO\CaisseBundle\Entity\AbstractTypeOperation as TypeOp;
use GO\CaisseBundle\Form\SortieSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GO\CaisseBundle\Entity\AbstractSortie;
use GO\GOLibrary\Utils\DateConstants as Cons;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sortie controller.
 *
 * @Route("sortie")
 */
class SortieController extends MainController
{
    // Menu vertical pour les sorties 
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Nouvelle Sortie", "id"=>"", "href"=> $this->generateUrl("sortie_new")),
           array("libelle"=>"Sortie du Jour", "id"=>"", "href"=>$this->generateUrl("sortie_index")),
           array("libelle"=>"Recherche Sortie", "id"=>"", "href"=>$this->generateUrl("sortie_search_index")),
            array("libelle"=>"Plus", "id"=>"", "href"=>"#", "dropdown"=>array(array(
                                                        "href"=>$this->generateUrl("type_sortie_new"), "libelle"=>"Créer Type Sortie"),
                                                        array("href"=>$this->generateUrl("type_sortie_index"), "libelle"=>"Liste Type Sortie",
                                                                                ))),
            );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all sortie entities.
     *
     * @Route("/", name="sortie_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $caisse= $this->getCaisse();
        $sorties = $em->getRepository('GOCaisseBundle:Sortie')->getListeSortie($caisse,Cons::AUJOURDHUI);
        $total = $em->getRepository('GOCaisseBundle:Sortie')->getTotalSortie($caisse,Cons::AUJOURDHUI);

        return $this->render('@GOCaisse/sortie/index.html.twig', array(
            'sorties' => $sorties,
            'total'=>$total
        ));
    }

    /**
     * Creates a new sortie entity.
     *
     * @Route("/new", name="sortie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sortie = new Sortie();
        $form = $this->createForm('GO\CaisseBundle\Form\SortieType', $sortie, array('session'=>$this->get("session")));
        $sortie->setDate(new \DateTime());
        $sortie->setUser($this->getUser());
        $sortie->setType(AbstractSortie::SORTIE_LIQUIE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        // réduire le solde de la caisse sur laquelle a porté l'opération 
        $caisse=$sortie->getCaisse(); $ancienSolde=$caisse->getSolde();
        $caisse->setSolde($ancienSolde-$sortie->getMontant())
                ->setLastOp(new \DateTime());
        //Ajouter la sortie dans l'historique des oprérations de caisse avec HistoCaisse Class
        $histoCaisse=new HistoCaisse();
        $histoCaisse->setAncienSolde($ancienSolde)
        ->setCaisse($caisse)
        ->setDateOp($sortie->getDate())
        ->setMontant($sortie->getMontant())
        ->setNouveauSolde($ancienSolde-$sortie->getMontant())
         //cet attribut permet de connaitre si l'opération est une sortie ou une entrée. Donc c'est le type 
         //d'opératation qui permet de différencier les sorties
        ->setTypeOp(TypeOp::SORTIE_LIQUIDE)
                ->setSortie($sortie)
                ->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($sortie);
            $em->persist($caisse);
            $em->persist($histoCaisse);
            $em->flush();

            return $this->redirectToRoute('sortie_show', array('id' => $sortie->getId()));
        }

        return $this->render('@GOCaisse/sortie/new.html.twig', array(
            'sortie' => $sortie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sortie entity.
     *
     * @Route("/{id}", name="sortie_show")
     * @Method("GET")
     */
    public function showAction(Sortie $sortie)
    {
        $deleteForm = $this->createDeleteForm($sortie);

        return $this->render('@GOCaisse/sortie/show.html.twig', array(
            'sortie' => $sortie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sortie entity.
     *
     * @Route("/{id}/edit", name="sortie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sortie $sortie)
    {
        $deleteForm = $this->createDeleteForm($sortie);
        $editForm = $this->createForm('GO\CaisseBundle\Form\SortieType', $sortie, array('session'=> $this->get('session')));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_edit', array('id' => $sortie->getId()));
        }

        return $this->render('@GOCaisse/sortie/edit.html.twig', array(
            'sortie' => $sortie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sortie entity.
     *
     * @Route("/delete/{id}", name="sortie_delete")
     */
    public function deleteAction(Request $request, Sortie $sortie)
    {
        $form = $this->createDeleteForm($sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $histoEntry=$em->getRepository("GOCaisseBundle:HistoCaisse")->findOneBySortie($sortie->getId());
            $histoEntry->setDeleted(true)->setDeletedAt(new \DateTime())->setSortie(null);
            $em->persist($histoEntry);
            $em->remove($sortie);
            $em->flush();
        }

        return $this->redirectToRoute('sortie_index');
    }

    /**
     * Creates a form to delete a sortie entity.
     *
     * @param Sortie $sortie The sortie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sortie $sortie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sortie_delete', array('id' => $sortie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    /**
     * 
     * @return type
     * @Route("/recherche/", name="sortie_search_index")
     */
    public function sortieSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new SortieSearchType(),$data);
         return $this->render('@GOCaisse/sortie/search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("search/get_result", name="caisse_pro_sortie_search")
     */
public function sortieSearchAction(Request $req)
    {
       
        $em=$this->getDoctrine()->getManager();
        $sortieRepo=$em->getRepository('GOCaisseBundle:Sortie');
        $liste= null;
        $sorties=null;
        $total_sortie=null;
        $total_benefice=null;
        $form=$this->createForm(new SortieSearchType(), array());
        $form->bind($req);
        $caisse= $this->getActiveCaisse();
         $totaux_poste_dep=array();
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);
        switch ($data['type_search'])
        {
            case 'total': $total_sortie=$sortieRepo->getTotalSortie($caisse,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
                break;
            case 'liste': $sorties=$sortieRepo->getListeSortie($caisse,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
            $total_sortie=$sortieRepo->getTotalSortie($caisse,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
            break;
        
            case 'poste_depense':
                $type=$this->getRepo('Charge')->find(3);
                $sorties=$sortieRepo->getListeTypeSortie($caisse, $type,Cons::DATE_INTERVALLE,$data['date_debut'], $data['date_fin']);
            
            break;  
         }       $postDepRepo=$em->getRepository('GOCaisseBundle:TypeSortie');
        $posteDepenes=$postDepRepo->findAll();
       
        foreach($posteDepenes as $posteDep)
        {
            $tot=array("montant"=>$sortieRepo->getTotalSortieType($caisse,$posteDep,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']),
                    "libelle"=>$posteDep->getLibelle());
                array_push($totaux_poste_dep, $tot);
        }
             
            
        
        
            }
        return $this->render('@GOCaisse/sortie/liste.html.twig', array('sorties'=>$sorties, 
            'total_sortie'=>$total_sortie,
                "total_postes"=>$totaux_poste_dep));
   
       }
}
