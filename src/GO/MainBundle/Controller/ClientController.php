<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\MainBundle\Entity\Client;
use GO\CaravaneBundle\Entity\Reservation;
use GO\CaravaneBundle\Controller\MainController;
use GO\MainBundle\Form\ClientType;
use GO\MainBundle\Form\ClientDetailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Description of ClientController
 *
 * @author hp
 */
class ClientController extends MainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
        $user=$this->getUser();
         $liste = array(array("libelle"=>"Ajouter", "href"=>"client_ajouter.golob"),
             array("libelle"=>"Recherche","href"=>"client_recherche.golob"),
             array("libelle"=>"Exporter Tous","href"=>"client_export_all.golob")
             );
        return $this->render('GOMainBundle:Client:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    public function indexAction(Request $req)
    {
        return $this->render('GOMainBundle:Client:index.html.twig');
    }
    public function formAction(Request $req)
    {
        $form= $this->createForm(new ClientType(), new Client());
      return $this->render('GOCaravaneBundle:Client:menu_vertical.html.twig', array('form'=>$form->createView()));
    }
    public function showAction(Request $req)
    {
    }
    
    public function upateAction(Request $req)
    {
        
    }
    public function ajouterAction(Request $req)
    {
        
        $client=$this->getRepo('Client')->findOneByTel($req->get('go_mainbundle_clientdetailtype')['tel']);
        if(empty($client))
        {
            $client=new Client();
        }
        $form= $this->createForm(new ClientDetailType(), $client);
        $form->bind($req);
        
        
        //verfier et valider le formulaire
        if($form->isValid())
        {
           $em=$this->em();
           $em->persist($client);
           $em->flush();
            return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig',
                    'msg'=>"Client enregistré avec succès"));
        } else {
        
        return $this->render('GOCaravaneBundle:Client:_form.html.twig', array('form'=>$form->createView()));
   
        }
        //ajouter le client dans la base donné
        
        //réponse à envoyer au client avec le message explicatif
    }
    //=========================SEARCH METHODS============
    public function searchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new ClientSearchType(),$data);
         return $this->render('GOMainBundle:Client:search_index.html.twig', 
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
        //var_dump($data);
        var_dump($data['type_search']);
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
            case 'ufr': //$liste=$clientRepo->findByTel(773300853);
                var_dump('ufrr'); exit;
                    break;
            case 'section': $liste=$clientRepo->findBySection($data['value']);
                    break;

        }
        }else
        {
            var_dump('Formulaire invalide');
           return $this->render('GOMainBundle:Client:search_index.html.twig', array('form'=>$form->createView()));
         
        }
        
            
        return $this->render('GOMainBundle:Client:search_result.html.twig', array('liste'=>$liste));
        
    }
    /**
* @Secure(roles="ROLE_SUPER_ADMIN")
*/
    public function exportAllAction(Request $req)
    {
        if($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))
        {
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        $clients= $this->getRepo('Client')->getAll();
        $donnees_text='';
        foreach($clients as $client)
        {
             
                    $donnees_text.=$client[0]->getPrenom(). ' '.$client[0]->getNom()." \t "
                    .$client[0]->getTel()." \t "
                    .$client[0]->getAdresse()." \t"
                    . $client['num_voy']."\r\n";
        
         }
        
         $filename="Liste-des-clients.txt"; $titre="Liste des clients Kheweul";
         $tableExpoText->export($donnees_text, $filename);
        
        }else
            return new Response("Zone interdite! Attention! On te suit partout!");
        }
        /**
         * 
         * @return Response
         * @Route("batch_processing", name="batch_processor")
         */
        
        public function batchProcessingAction()
        {
            
        }
}
