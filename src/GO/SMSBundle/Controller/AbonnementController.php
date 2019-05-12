<?php

namespace GO\SMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\SMSBundle\Entity\Abonnement;
use GO\SMSBundle\Entity\PayerAbonnement;
use GO\SMSBundle\Form\AbonnementType;
use GO\SMSBundle\Form\AbonnementSearchType;
use GO\SMSBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\Constants as ConsShop;
class AbonnementController extends MainController {
    
     public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Nouvel abonnement", "id"=>"", "href"=>"creer_abonnement"),
           array("libelle"=>"Recherche Abonnement", "id"=>"", "href"=>"abonnement_search_index"),
           array("libelle"=>"Liste des Abonnements", "id"=>"", "href"=>"abonnement_afficher_liste"),
           array("libelle"=>"Exporter", "id"=>"", "href"=>"abonnement_export", "vars"=>array("format"=>"pdf"))
           );
        return $this->render('GOSMSBundle::menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * @Route("abonnement_index.golob", name="abonnement_index")
     */
    public function indexAction(Request $req) {
        return $this->render('GOSMSBundle:Abonnement:index.html.twig');
    }

    /**
     * @Route("abonnement_add.golob", name="creer_abonnement")
     */
    public function newAction(Request $req)
    {
        //var_dump("djdjjdj");
        $entity = new Abonnement();
        $form   = $this->createForm(new AbonnementType(), $entity);
        if($req->getMethod()=="POST")
        {
            $form->bind($req);
            $entity->setDateExpir(new \DateTime("+".$entity->getFormule()->getDuree()." months"));
            $entity->setUser($this->getUser());
            if($form->isValid())
            {
                //vérifie si le client n'a pas déjà fait un abonnement
                if($this->getRepo('Abonnement')->findByClient($form->getData()->getClient())==null)
                {
                $em= $this->em();
                $em->persist($entity);
                $nombre_mois=$entity->getFormule()->getDuree();
                $mois_en_cours=intval(\Date('m'));
                $annee_en_cours=intval(\Date('Y'));
                $montant_mois=$entity->getFormule()->getTarifMois();
                $moisRepo= $this->getDoctrine()->getEntityManager()->getRepository('GOMainBundle:Mois');
                for($i=0;$i<$nombre_mois;$i++)
                {
                    $count=$i;
                    $mois_pay=$mois_en_cours+$i;
                    if($mois_pay<=12)
                    {
                     //  $moi 
                    //var_dump($mois_pay);
                    
                    }else
                    {
                    $mois_pay=$mois_pay-12;
                    $annee_en_cours=intval(\Date('Y'))+1;
                    }
                    $paiement=new PayerAbonnement();
                    $paiement->setAbonnement($entity);
                   $paiement->setMois($moisRepo->find($mois_pay));
                    $paiement->setAnnee($annee_en_cours);
                    $paiement->setMontant($montant_mois);
                    $paiement->setUser($this->getUser());
                    $em->persist($paiement);
                }
                $em->flush();
                return $this->sendResponse(array('msg'=>"Abonnement crée avec succès! Numéro abonnement: ".$entity->getId()));
                }else
                {
                    $this->errorMsg="Le client a déjà fait un abonnement!";
                }
            }else
            {
                return $this->render('GOSMSBundle:Abonnement:_form.html.twig', array('form'=>$form->createView()));
        
            }
            return $this->sendResponse(array('errorMsg'=> $this->errorMsg));
        }
        
        
        return $this->render('GOSMSBundle:Abonnement:_form.html.twig', array('form'=>$form->createView()));
        //return $this->render('GOShopBundle::lajyout.html.twig', array('form'=>$form->createView()));
        
      
    }
    /**
     * @Route("abonnement_show.golob", name="abonnement_afficher_liste")
     */
    public function showAction(Request $req)
    {
        $abonnements= $this->getRepo('Abonnement')->findAll();
        
        return $this->render('GOSMSBundle:Abonnement:liste.html.twig', array('abonnements'=>$abonnements));
       
        
      
    }
    /**
     * @Route("abonnement_search_index.golob", name="abonnement_search_index")
     */
    public function showSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new AbonnementSearchType(),$data);
         return $this->render('GOSMSBundle:Abonnement:_search_form.html.twig', 
                array('form'=>$form->createView()));
    }
    /**
     * @Route("abonnement_search.golob", name="abonnement_search")
     */
    public function searchAction(Request $req)
    {
        $abonmRepo=$this->getRepo('Abonnement');
        $liste= null;
        $form=$this->createForm(new AbonnementSearchType(), array());
        $form->bind($req);
        
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);
        switch ($data['type_search'])
        {
            case 'tel': $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_TEL,$data['value']);
                break;
            case 'prenom': $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_PRENOM,$data['value']);
                break;
            case 'nom': $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_NOM,$data['value']);
                break;
            case 'adresse': $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_ADRESSE,$data['value']);
                break;
            case 'village': 
                $village= $this->getDoctrine()->getEntityManager()->getRepository('GOMainBundle:Village')->find($data['value']);
                
                $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_VILLAGE,$village);
                break;
            case 'formule': 
                $formule=$this->getRepo('formule')->find($data['value']);
                $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_FORMULE,$formule);
                break;
            case 'date': 
                $liste=$abonmRepo->findAbonnementBy(Cons::FIND_BY_DATE,"", $data['value'],$data['value']);
                break;
            
        }
        
            }
        return $this->render('GOSMSBundle:Abonnement:liste.html.twig', array('abonnements'=>$liste));
        
    }
     /**
     * @Route("abonnement_export-pdf.golob", name="abonnement_export")
     */
    public function exportAction(Request $req)
    {
        /* Cette fonction permet d'exporter la liste des abonnements  selon le format
        choisi, soit en PDF soit au format texte         */
        
        $abonmRepo=$this->getRepo('Abonnement');
        // Récupération de la liste des abonnees
        //if($req->get('filter')==Cons::PAYE)
        $listeAbonm=$abonmRepo->findAll();
        //elseif($req->get('filter')==Cons::NON_PAYE)
        //$listeAbonm=$abonmnRepo->getListePayesRes($req->get('id_dep'),Cons::NON_PAYE);
       //Instantitiation des classes qui gèrenet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        //récupérattion du départ
        /*$abonnement=$depRepo->find($req->get('id_dep'));
        si le départ n'existe pas, une exception NotFound sera levée
        if(empty($abonnement))
        {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Le départ introuvbale');          
        }*/
        //SI le format choisi est PDF 
       // if(strtolower($req->get('format')))
        if(1==2)
        {//déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite passé à la fonction qui exporte les données, laquelle fonction prend en parametre
            //un tableau et non des objets
            $donnees=array();
            
        foreach($listeAbonm as $abonmnt)
        {
            $client=$abonmnt->getClient();
            
            $arr=array($client->getPrenom(). ' '.$client->getNom(), 
                $client->getTel(),
                $abonmnt->getFormule()->getAbrv(),
                $abonmnt->getDate()->format('d/m/Y H:i:s'),
                $abonmnt->getDateExpir()->format('d/m/Y H:i:s'),
                $abonmnt->getUser()->getPrenom(),
               );
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //définition des colonnes du tableau
        $columns=array(
            array("name"=>"Client", "width"=>45),
            array("name"=>"Téléphone", "width"=>20),
            array("name"=>"Formule", "width"=>20),
            array("name"=>"Date abonné", "width"=>40),
            array("name"=>"Date Expir", "width"=>40),
            array("name"=>"inscrit par", "width"=>20),
            ); 
        // déclarion des variables pour le fichier de sortie
        $filename="Liste des abonnés .txt"; 
        $titre="Liste des abonnés à la formule";
        //Exporter les données
        $tableExpoPDF->export($donnees, $columns, $filename, $titre);
        }
        //if(strtolower($req->get('format'))=="text")
        if(1==1)
        {
        ////déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de text
            //Cette variable sera ensuite passée à la fonction qui exporte les données, laquelle fonction prend en parametre
            //string et  non des objets
         
        $donnees_text='';
        foreach($listeAbonm as $abonmnt)
        {
            $client=$abonmnt->getClient();
            $donnees_text.=$client->getPrenom(). ' '.$client->getNom()." \t "
                    .$client->getTel()." \t "
                    .$abonmnt->getFormule()->getAbrv()." \t"
                            .$abonmnt->getDate()->format('d/m/Y H:i:s')." \t"
                    .$abonmnt->getDateExpir()->format('d/m/Y H:i:s')."\r\n";
        
         }
        
         $filename="Liste Des Abonnés.txt";
         $tableExpoText->export($donnees_text, $filename);
        }
           
        
    }
     /**
     * @Route("abonnement_chiffre_index.golob", name="abonnement_chiffre_index")
     */
     public function chiffreIndexAction(Request $req)
     {
         
     }
     /**
     * @Route("abonnement_chiffre.golob", name="abonnement_chiffre")
     */
     public function chiffreShowAction(Request $req)
     {
         $PaiementRepo=$this->getRepo('PayerAbonnement');
        $total=$PaiementRepo->getPaiement($this->getUser(),ConsShop::MOIS);
        $total_auj=$PaiementRepo->getPaiement($this->getUser(),ConsShop::AUJOURDHUI);
        $abRepo=$this->getRepo('Abonnement');
        $nombre_ab_today= $abRepo->getNombreAbonnement(ConsShop::AUJOURDHUI);
        $nombre_ab_mensuel= $abRepo->getNombreAbonnement(ConsShop::MOIS);
        $nombre_ab_total= $abRepo->getNombreAbonnement(ConsShop::DATE_INTERVALLE,'2017-09-01');
        $donnees=array(
            'total_today'=>$total_auj,
            'total'=>$total, 
            'nombre_ab_today'=>$nombre_ab_today,
            'nombre_ab_mensuel'=>$nombre_ab_mensuel,
            'nombre_ab_total'=>$nombre_ab_total);
        return $this->render('GOSMSBundle:Abonnement:chiffre.html.twig', $donnees);
     }
     
     /**
     * @Route("abonnement_delete-{id}.golob", name="abonnement_delete")
     */
     public function desabonnerAction(Abonnement $abonnement)
     {
         $em= $this->em();
         $em->remove($abonnement);
         $em->flush();
         $msg="Abonnement Supprimé avec succès!";
         return $this->sendResponse(array("msg"=>$msg));
         
     }
     /**
     * @Route("abonnement_update-{id}.golob", name="abonnement_update")
     */
     public function updateAction(Abonnement $abonnement)
     {
         $form= $this->createForm(new AbonnementType(), $abonnement);
         if($req->getMethod()=="POST")
        {
            $form->bind($req);
            if($form->isValid())
            {
                $em= $this->em();
                $em->persist($abonnement);
                $em->flush();
            return $this->sendResponse(array('msg'=>'Modifactions enregistrées avec succès!'));
            }
            else
            {
            return $this->sendResponse(array('errorMsg'=>'Données saisies non valides!'));
            }
            
        }
                if($req->isXmlHttpRequest())
       return $this->render('GOSMSundle:Abonnement:_update_form.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOSMSBundle:Abonnement:_update_form.html.twig', array("form"=>$form->createView()));
      
         
     }
}
