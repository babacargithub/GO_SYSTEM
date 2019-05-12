<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\MainBundle\Entity\Client;
use GO\MainBundle\Config\CarteKheweulConfig;
use GO\MainBundle\Utils\Constants as Cons;
use GO\MainBundle\Entity\CarteKheweul;
use GO\MainBundle\Form\ClientType;
use GO\MainBundle\Form\ClientDetailType;
use GO\MainBundle\Form\CarteKheweulType;
use GO\MainBundle\Form\CarteKheweulSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\FatalErrorException;

class CarteKheweulController extends \GO\CaravaneBundle\Controller\MainController{
    //put your code here
    public function indexAction(Request $req)
    {}
    public function menuVerticalAction(Request $req)
    {
        $user=$this->getUser();
         $liste = array(array("libelle"=>"Nouvelle Carte", "href"=>"c_kheweul.golob"),
             array("libelle"=>"Recherche","href"=>"search_index_c_kheweul.golob"),
             array("libelle"=>"Liste","href"=>"show_c_kheweul.golob"));
             
         if($this->get('security.context')->isGranted('ROLE_ADMIN'))
         {
             array_push($liste, array("libelle"=>"Promo","href"=>"promo_index.golob"));
             array_push($liste, array("libelle"=>"Exporter","href"=>"export_index_c_kheweul.golob"));
         }
        return $this->render('GOMainBundle:CarteKheweul:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    protected function numCarteGenerator($id, $type) {
        if(is_numeric($id)&&is_numeric($type))
        {
                $id_length=strlen($id);
                
                if($id_length<5)
                {
                    switch ($id_length)
                    {
                        case 1: $id="0000".$id; 
                            break;
                        case 2: $id="000".$id; 
                            break;
                        case 3: $id="00".$id; 
                            break;
                        case 4: $id="0".$id; 
                            break;
                    }
                }
                $now= \DATE('dmy');
                return  $type.''.$id.''.$now;
        }
        throw new FatalErrorException('Cannot generate Numero Carte. id ou type not an integer');
       
    }
    public function addAction(Request $req)
    {
         $msg=null; $errorMsg=null;
        $c_kheweul=new CarteKheweul();
        $clientRepo=$this->getRepo('Client');
       $form= $this->createForm(new CarteKheweulType(), $c_kheweul);
       
       //Récupération du client
       if($this->get('gocar.custom_validator')->isValideTelephone($req->get('go_mainbundle_cartekheweultype')['client']))
       {
           $form->bind($req);
           $client=$clientRepo->findOneByTel($req->get('go_mainbundle_cartekheweultype')['client']);
           if($client==null)
           {
               exit("Client Introuvable!");
           }elseif($this->getRepo('CarteKheweul')->findOneByClient($client->getId())!=null)
           {
               exit('Le client a déjà une carte à son nom! Vérifiez les données saisies!');
           }
           // Génération du numéro de la carte 
       $c_kheweul->setClient($client);
       
       
        if($form->isValid())
       {
            $num_carte=$this->numCarteGenerator($client->getId(),$form->getData()->getType()->getId() );
           $config=new CarteKheweulConfig();
           if($clientRepo->getNombreVoyage($client->getTel()) >= $form->getData()->getType()->getNumVoyage())
           {
           $c_kheweul->setNumCarte($num_carte);$em= $this->em();
           $em->persist($c_kheweul);
           $em->flush();
           $msg='Carte ajoutée avec succès!';
           return $this->render('GOMainBundle::layout.html.twig', array('msg'=>$msg));
           }else
           {
               return new Response('Nombre de voyage nécessaire pour la carte '.$form->getData()->getType()->getLibelle().' non atteint par le client.');
           }
      
       }else
       {
          return $this->render('GOMainBundle:CarteKheweul:index.html.twig', array('form'=>$form->createView()));
       }
       }else
       {
           exit('Téléphone invalide!');
       }
      
    }
    public function formAction()
    {
        $config=new CarteKheweulConfig();
        $config->getNombreVoy(Cons::NOMBRE_VOY_VIP);
        $form= $this->createForm(new CarteKheweulType(), new CarteKheweul());
      return $this->render('GOMainBundle:CarteKheweul:index.html.twig', array('form'=>$form->createView()));
    
    }
    public function updateAction()
    {}
    public function showAction()
    {
        $cartes=$this->getRepo('CarteKheweul')->findAll();
        return $this->render('GOMainBundle:CarteKheweul:show_liste.html.twig', array("cartes"=>$cartes));
    }
    //==================== SEARCH FUNCTIONS===========
    public function searchIndexAction(Request $req)
    {
        $data = array();
                $form = $this->createForm(new CarteKheweulSearchType(),$data);
                /*$form = $this->createFormBuilder($data)
                ->add('num_carte', 'text')
                ->add('num_client', 'text')->getForm();*/
        return $this->render('GOMainBundle:CarteKheweul:search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    public function searchAction(Request $req)
    {
        $form=$this->createForm(new CarteKheweulSearchType(), array());
        $form->bind($req);
        if($form->isValid())
        {
            $carte=null;
        $data=$form->getData();
        //var_dump($data);
        switch ($data['type_search'])
        {
            case 'num_carte': $carte=$this->getRepo('CarteKheweul')->findOneByNumCarte($data['value']);
                break;
            case 'num_client': $carte=$this->getRepo('CarteKheweul')->findOneByClient($data['value']);
                break;
            case 'tel': if($this->getRepo('Client')->findOneByTel($data['value'])!=null)
            {$carte=$this->getRepo('CarteKheweul')->findOneByClient($this->getRepo('Client')->findOneByTel($data['value'])->getId());
            }break;

        }
        
        if($carte!=null)
        {
         return $this->render('GOMainBundle:CarteKheweul:details_carte.html.twig', array('carte'=>$carte));
       
        }else
        {$errorMsg=" Carte introuvable";
             return $this->render('GOMainBundle:CarteKheweul:search_index.html.twig', 
                array('form'=>$form->createView(), 'error'=>$errorMsg));
        }
        }else
        {
        return $this->render('GOMainBundle:CarteKheweul:search_index.html.twig', 
                array('form'=>$form->createView()));
        }
    }
    //============EXPORT FUNCITONS
    public function exportIndexAction()
    {
        return $this->render('GOMainBundle:CarteKheweul:export_index.html.twig');
    }
    public function exportAction(Request $req)
    {
        /* Cette fonction permet d'exporter la liste des clients ayant une carte selon le format
        choisi, soit en PDF soit au format texte         */
        
        $c_kheweulRepo=$this->getRepo('CarteKheweul');
        // Récupération de la liste des clients
        $cartes=$c_kheweulRepo->findAll();
       //Instantitiation des classes qui gèrenet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
        //SI le format choisi est PDF 
        if(strtolower($req->get('format'))=="pdf")
        {//déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite passé à la fonction qui exporte les données, laquelle fonction prend en parametre
            //un tableau et non des objets
            $donnees=array();
            
        foreach($cartes as $carte)
        {
            
            $arr=array($carte->getType()->getLibelle(),
                $carte->getClient()->getPrenom(). ' '.$carte->getClient()->getNom(), 
                $carte->getNumCarte(),
                $carte->getClient()->getId(),
                $carte->getClient()->getTel(),
                $carte->getDateDeliv()->format('d/m/Y'),
                $carte->getDateExp()->format('d/m/Y'),
                $carte->getActive(),
                
                );
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //définition des colonnes du tableau
        $columns=array(
            array("name"=>"Statut", "width"=>25),
            array("name"=>"Client", "width"=>45),
            array("name"=>"Numéro", "width"=>30),
            array("name"=>"Num Client", "width"=>20),
            array("name"=>"Téléphone", "width"=>25),
            array("name"=>"Deliv", "width"=>20),
            array("name"=>"Expir", "width"=>20),
            array("name"=>"Active", "width"=>10)); 
        // déclarion des variables pour le fichier de sortie
        $filename="Liste Clients avec Carte";
        $titre="Liste Clients avec Carte";
        //Exporter les données
        $tableExpoPDF->export($donnees, $columns, $filename, $titre);
        }
        if(strtolower($req->get('format'))=="text")
        {
        ////déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de text
            //Cette variable sera ensuite passée à la fonction qui exporte les données, laquelle fonction prend en parametre
            //string et  non des objets
         
        $donnees_text='';
        foreach($cartes as $carte)
        {
             $client=$carte->getClient();
                    $donnees_text.=$client->getPrenom(). ' '.$client->getNom()." \t "
                    .$client->getTel()." \t "
                    .$carte->getNumCarte()." \t"
                            .$carte->getDateDeliv()->format('d/m/Y')." \t"
                    .$carte->getDateExp()->format('d/m/Y')."\r\n";
        
         }
        
         $filename="Liste client.txt";
         $tableExpoText->export($donnees_text, $filename);
        }
           
        
    }
    //========== METHODES POUR LA GESTION DES PROMOS ET DES REDUCTIONS ============================
    public function promoIndexAction()
    {
        
    }
    public function promoAction(Request $req)
    {
        
    }
}
