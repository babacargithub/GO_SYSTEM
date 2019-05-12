<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\CaravaneBundle\Entity\Client;
use GO\CaravaneBundle\Entity\Reservation;
use GO\CaravaneBundle\Form\ClientType;
use GO\MainBundle\Form\ClientSearchType;
use Symfony\Component\HttpFoundation\Request;
use GO\MainBundle\Controller\ClientController as ClientMainController;
use GO\CaravaneBundle\Utils\Constants as Cons;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Description of ClientController
 *
 * @author hp
 */
class ClientController extends ClientMainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
      $liste = array(
             array("libelle"=>"Ajouter", "href"=>"client_ajouter.golob"),
             array("libelle"=>"Recherche","href"=>"search_index_client.golob"),
             array("libelle"=>"Exporter","href"=>"client_exporter.golob"),
             array("libelle"=>"Export Res En Cours","href"=>"export_all_res_en_cours.golob")
             );
      return $this->render('GOCaravaneBundle:Client:menu_vertical.html.twig', array("menu_vertical"=>$liste));
  
      
    }
    public function indexAction(Request $req)
    {
     $liste=$this->getRepo('Client')->getClientsKheweul(Cons::CLIENTS_KHEWEUL);
     //var_dump($liste); die();
      return $this->render('GOCaravaneBundle:Client:index.html.twig', array("liste_clientsd"=>$liste));
  
      
    }
    //=========================SEARCH METHODS============
    public function searchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new ClientSearchType(),$data);
         return $this->render('GOCaravaneBundle:Client:search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    public function searchAction(Request $req)
    {
        $clientRepo=$this->getRepo('Client');
        $liste= null;
        $form=$this->createForm(new ClientSearchType(), array());
        $form->bind($req);
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data['ufr']);exit();
        switch ($data['type_search'])
        {
            case 'num_carte': $carte=$this->getRepo('CarteKheweul')->findOneByNumCarte($data['value']);
                $liste=$clientRepo->findByTel($carte->getClient()->getTel());
                break;
            case 'prenom': $liste=$clientRepo->findByPrenom($data['value']);
                break;
            case 'nom': $liste=$clientRepo->findByNom($data['value']);
                break;
            case 'tel': $liste=$clientRepo->findByTel($data['value']);
                    break;
                case 'ufr': $liste=$clientRepo->findByUfr($data['ufr']->getId());
                
                    break;
            case 'section': $liste=$clientRepo->findBySection($data['section']);
                    break;

        }
        
            }
        return $this->render('GOCaravaneBundle:Client:search_result.html.twig', array('liste'=>$liste));
        
    }
    public function exportAction(Request $req)
    {
        /* Cette fonction permet d'exporter la liste des réservations sur un départ donné selon le format
        choisi, soit en PDF soit au format texte         */
        
        $ClientRepo=$this->getRepo('Client');
        
        // Récupération de la liste des clients
        $clients=$ClientRepo->getClientsKheweul(Cons::CLIENTS_KHEWEUL);
        //Instantitiation des classes qui gèrenet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
        
        //SI le format choisi est PDF 
        if(strtolower($req->get('format'))=="pdf")
        {//déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite passé à la fonction qui exporte les données, laquelle fonction prend en parametre
            //un tableau et non des objets
            $donnees=array();
            
        foreach($clients as $client)
        {
           // les clients seront accessibles depuis l'index 0, la requette étant faite avec Docttine, elle contient 
            //colonnes en alias; qui sont transformé en arry; du coup chaque entrée contient 2 arrays: array 0 représent $
            //l'objet client, array 1 repréte l'array de la colone alias qui est ici num voy. accessible depuis l'index num voy
            $arr=array(
                $client[0]->getId(),
                $client[0]->getPrenom(),
                $client[0]->getNom(), 
                $client[0]->getTel(),
                $client[0]->getAdresse(),
                $client[0]->getPromo(),
                $client['num_voy']);
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //définition des colonnes du tableau
        $columns=array(
            array("name"=>"Code", "width"=>15),
            array("name"=>"Prénom", "width"=>45),
            array("name"=>"Nom", "width"=>25),
            array("name"=>"Téléphone", "width"=>25),
            array("name"=>"Adresse", "width"=>15),
            array("name"=>"Promo", "width"=>18),
            array("name"=>"NombVoyage", "width"=>30)); 

// déclarion des variables pour le fichier de sortie
        $filename="Liste Client "; $titre="Liste des clients Khéweul ";
        //Exporter les données
        $tableExpoPDF->export($donnees, $columns, $filename, $titre);
        }
        if(strtolower($req->get('format'))=="text")
        {
        ////déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de text
            //Cette variable sera ensuite passée à la fonction qui exporte les données, laquelle fonction prend en parametre
            //string et  non des objets
         
        $donnees_text='';
        foreach($clients as $client)
        {
             
                    $donnees_text.=$client[0]->getPrenom(). ' '.$client[0]->getNom()." \t "
                    .$client[0]->getTel()." \t "
                    .$client[0]->getAdresse()." \t"
                    . $client['num_voy']."\r\n";
        
         }
        
         $filename="Liste-des-clients-Kheweul.txt"; $titre="Liste des clients Kheweul";
         $tableExpoText->export($donnees_text, $filename);
        }
           
        
    }
  
    /**
     * @Route("/ajouter_client.golob", name="go_caravane_client_new")
     */
   public function newAction(Request $req)
    {
        
      
        $Client=new Client();
        $form= $this->createForm(new ClientType(), $Client,["action"=> $this->generateUrl("go_caravane_client_new")]);
        $form->handleRequest($req);
       
        if($form->isSubmitted()&&$form->isValid())
        {
            $Client->getCoordonnees()->setCreatedAt(new \DateTime());
           $em=$this->em();
           $em->persist($Client->getCoordonnees());
           $em->persist($Client);
           $em->flush();
            return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig',
                    'msg'=>"Client enregistré avec succès"));
        } else {
        
        return $this->render('GOCaravaneBundle:Client:_form.html.twig', array('form'=>$form->createView()));
   
        }
        
    }
    public function getDetailsAction(Request $req)
    {
        $client=$this->getRepo('Client')->findOneByTel($req->get('tel'));
          $clientForm= $this->createForm(new ClientDetailType(), $client);
        $voyage_en_cours= null;
        //si le client existe dans la base, on va compter le nombre de voyages qu'il a effectué, sinon on ne fait rien
        if(!empty($client))
        {
        $clientForm->get('nombre_voy')->setData($this->getRepo('Reservation')->getNombreVoyage($client->getTel()));
        $en_cours=$this->getRepo('Reservation')->getDernierVoyage($client->getTel());
        if(!is_null($en_cours))
            $voyage_en_cours=$en_cours;
        }
        return $this->render('GOCaravaneBundle:Client:_details.html.twig', 
                                array('voyage_en_cours'=>$voyage_en_cours,'form'=>$clientForm->createView(), 'data'=>$clientForm->getData()));
    }
    
}
