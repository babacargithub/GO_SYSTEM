<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace GO\CaravaneBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\MainBundle\Entity\Client;
use GO\CaravaneBundle\Entity\Depart;
use GO\CaravaneBundle\Entity\Evenement;
use GO\CaravaneBundle\Entity\Payer;
use GO\UserBundle\Entity\User;
use GO\CaravaneBundle\Entity\Reservation;
use GO\CaravaneBundle\Entity\PayerRepository;
use GO\MainBundle\Entity\Challenger;
use GO\MainBundle\Form\ClientType;
use GO\CaravaneBundle\Form\DepartType;
use GO\CaravaneBundle\Form\ReservationType;
use GO\CaravaneBundle\Form\ReservationEditType;
use Symfony\Component\HttpFoundation\Request;
use GO\CaravaneBundle\Utils\Constants as Cons;
use GO\UserBundle\Utils\Constants as ConsUser;
use GO\MainBundle\Utils\SMSSender;
use GO\CaravaneBundle\Utils\OrangeMoneyPayment;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
class ReservationController extends MainController{
    //put your code here
    public function menuVerticalAction(Request $req)
    {
        $liste=array();
        $listedep = $this->getRepo('Depart')->getListeDeparts(Cons::DEPART_TROIS_JR)->getQuery()->getResult();
        foreach($listedep as $depart)
        {
            $menu=array("href"=> $this->generateUrl("go_caravane_reservation_liste_show", array('id'=>$depart->getId())),
                        "libelle"=>$depart->getLibelle()
                    );
                    array_push($liste, $menu);
        }
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
     
    public function menuVerticalChiffreAction(Request $req)
    {
        $departRepo=$this->getRepo('Depart');
        $events=$this->getRepo('Evenement')->getEventsEnCours()->getQuery()->getResult();
        $liste=array();
       
        foreach($events as $event)
        {   
        $listedep=$departRepo->getDepartsEvent($event->getId());
        
        foreach($listedep as $depart)
        {
            $menu=array("href"=> $this->generateUrl("go_caravane_chiffre_depart", array('id_dep'=>$depart->getId())),
                        "libelle"=>$depart->getLibelle()
                    );
                    array_push($liste, $menu);
        }
        
        }
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
   
        
       
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/index", name="go_caravane_res_index")
    */
    public function indexAction(Request $req)
    {
        $res= new Reservation();
        $client=new Client();
        $form= $this->createForm(new ReservationType(), $res);
        $clientForm= $this->createForm(new ClientType(), $client);
        return $this->render('GOCaravaneBundle:Reservation:index.html.twig', array("form"=>$form->createView(),"clientForm"=>$form->createView()));
     }
      /**
     * 
     * @param Request $req
     * @return type
     * @Route("reservation/new", name="go_caravane_reservation_ajouter")
    */
    public function addAction(Request $req)
    {
        $msg=null;
        $errorMsg=null;
       $request=$req;
         $CustomValidator=$this->get('gocar.custom_validator');
         $em=$this->em();
        $clientRepo=$this->getDoctrine()->getRepository('GOCaravaneBundle:Client');
        $resRepo=$this->getRepo('Reservation');
        $res= new Reservation();
        
      
        $resForm= $this->createForm(new ReservationType(),$res);
         
        $resForm->handleRequest($request);
       
        $res->setConfirme(false);
        $res->setDate(new \DateTime());
        
        $res->setAgent($this->getUser());
        //=== v�rifier si le formulaire est valide
         if($resForm->isValid())
        {
             //=== V�rifier si les r�servations ne sont pas clotur�es pour le d�part s�lectionn�
          if($res->getDepart()->getClosRes()==false)  
          {
              //v�rifie si le t�l�phone est valide  
              //if($CustomValidator->isValideTelephone($res->getClient()->getTel()))
                if(1>0){
                $em->persist($res->getClient());
                if($resRepo->reservationExists($res->getClient()->getTel(), $res->getDepart()))
                {
                    $errorMsg="Le client a d�j� fait une reservation sur ce d�part: ".$res->getDepart()->getLibelle();
                }
                else
                { 
                    $em->persist($res);
                    $em->flush();
                            $msg="R�servation enregistr�e avec succ�s!";
                            //envoyer une notification SMS au client
                            $heure_rv=$res->getHeureDepart()->format('H\h:i');

                            $pointDep=$res->getPointDep();
                            $arret=$pointDep->getArretBus();
                            $client=$res->getClient();
                            $depart=$res->getDepart();
                             $tel=$client->getTel();
                             $client_data=$client->getPrenom();
                            
                             //pr�parer la notification � envoyer aux clients apr�s r�servation r�uissi
                            
                            $form_name='go_caravanebundle_reservationtype';
                           if(isset($req->request->get($form_name)['paye']) && $req->request->get($form_name)['paye']==true)
                           {
                               if($this->getUser()->hasRole('ROLE_AG_BOUT'))
                                {
                               $code=$this->payer($res);
                               $res= $this->attribuerNumPlace($res);
                              $msg.=" ".$code. " Num�ro place: <strong>".$res->getNumPlace()."</strong>";
                                }else
                                 {
                                     $errorMsg="Impossible d'enregistrer le paiement. Motif: Vous ne disposez pas de compte boutiquier. Seuls les comptes boutiquiers sont autoris�s � effectuer des paiements";
                                }   
                           }
                            $notification= $this->getNotificationMessage($res);
                            SMSSender::send(substr($tel,-9,9), $notification);


                 }
                }else
                {
                    $errorMsg="T�l�phone invalide!";
                } 
          }else
          {
              $errorMsg="Les r�servations sont cl�tur�es sur ce d�part";
          }
        } else {
        }
        return $this->sendResponse(array(
               "view"=>'GOCaravaneBundle:Reservation:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg,
               "responseVars"=> array('form'=>$resForm->createView()
                )));
        
  
 
       
   }
   
    /**
     * @Route("/reservation/{id}/cancel", name="go_caravane_reservation_delete")
     */
    public function deleteAction(Reservation $res, Request $req)
    {
        $resRepo=$this->getDoctrine()->getRepository('GOCaravaneBundle:Reservation');
          if(!empty($res))
         {$payRepo=$this->getDoctrine()->getRepository('GOCaravaneBundle:Payer');
        $paye=$payRepo->findOneByRes($res->getId());
         $em=$this->getDoctrine()->getManager();
         $em->remove($res);
         
         }if(!empty($paye))
         {
         $em->remove($paye);
         }
        $em->flush();
         
         $this->msg="R�servation annul�e avec succ�s!";
         return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig','msg'=>$this->msg));
        
    }
   /**
     * @Route("reservation/{id}/payer", name="go_caravane_reservation_payer")
     */
    public function payerAction(Reservation $res, Request $req)
    {
        $challengr=new Challenger();
        $challengr->setPrenom('Babacar');
        $challengr->setNom('SEYE');
        $challengr->setAdresse('114L');
        $challengr->setTel(773300853);
        $challengr->setEmail('dhhf@jjf.jf');
        $resRepo=$this->getDoctrine()->getRepository('GOCaravaneBundle:Reservation');
        $payRepo=$this->getDoctrine()->getRepository('GOCaravaneBundle:Payer');
          $msg=null;
        //========V�rifie si les paiements ne sont pas cl�tur�s pour le d�part s�lectionn�
        if($res->getDepart()->getClosPaye()==false)
        {
            //=== V�rifier si la r�servation n'est pas d�ja pay�e =====
       
            if(empty($payRepo->findOneByRes($res->getId())))
            {
                $paye=new Payer();
                $paye->setRes($res);
                $paye->setDate(new \DateTime());
                $paye->setMontant($res->getDes()->getTarif());
                $User= $this->getUser();
                $code=$User->getId().$res->getId();
                $paye->setCodeRecu(intval($code));
                $paye->setAgent($User);
                $res->setConfirme(true);
                $res->setPaye(true);
                $paye->setRes($res);
                $em=$this->em();
                $em->persist($paye);
                $em->flush();
                $res->setPaiement($paye);
                //$em->persist($res);
               // $em->persist($challengr);
                if($this->getUser()->hasRole('ROLE_AG_BOUT'))
                {
                $em->persist($res);
                $em->flush();
                $res= $this->attribuerNumPlace($res);
                $msg="Paiement enreistr� avec succ�s! Voici le code:  <strong>".$paye->getCodeRecu()."</strong> Num�ro place: <strong>".$res->getNumPlace()."</strong> " ;
                $notif="Paiement enreistr� avec succ�s! Num�ro place: ".$res->getNumPlace()." R�f�rence : ".$paye->getCodeRecu() ;
                SMSSender::send($res->getClient()->getTel(), $notif);
                }else
                {
                    $this->errorMsg="Impossible d'enregistrer le paiement. Motif: Vous ne disposez pas de compte boutiquier. Seuls les comptes boutiquiers sont autoris�s � effectuer des paiements";
                }
                
            }else
        {
            //updating reservation entity so that paye will be set tp true
            $res->setPaye(true);
            $em=$this->em();
            $em->persist($res);
            $em->flush($res);
            $msg="Cette r�servation a �t� d�j� pay�e!";
        }
        }else
        {
            $msg="Les paiements sont clotur�s pour le d�part s�lectionn�";
        }
       // return $this->render('GOCaravaneBundle:Reservation:index.html.twig', array('msg'=>$msg));
        $this->msg=$msg;
        //$this->errorMsg=$errorMsg;
         return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig', 'msg'=>$this->msg, 'errorMsg'=> $this->errorMsg));
        
    }
    /**
     * 
     * @param Reservation $res
     * @param Request $req
     * @return type
     * @Route("reservation/{id}/update", name="go_caravane_reservation_update")
     */
    public function updateAction(Reservation $res, Request $req)
    {
        $resForm= $this->createForm(new ReservationEditType, $res);
        if($req->getMethod()=="POST")
        {
                    $resForm->handleRequest($req);
                    $ancien_num=$res->getNumPlace();
                    //-- Si le d�part est pass�, on d�clenche une erreur
                     if($res->getDepart()->isPasse())
                    {
                        exit("Erreur: vous ne pouvez pas vous inscrire sur un d�part pass�");
                    }
                    if($res->getDepart()->isResClos())
                    {
                        $msg="Erreur: Les r�servations sont cl�tur�es";
                        return $this->sendResponse(array("errorMsg"=>$msg));
                    }
                   
                    $em= $this->em();
                    //==========V�rifier si la r�sevation a �t� pay� , si oui on modifie le paiement selon la destination
                    $payer=$res->getPaiement();
                    // si le paiement existe avec u objet non vide, on modifie le paiemnt 
                    if($payer!==null and $payer instanceof Payer)
                    {
                        $payer->setMontant($res->getDes()->getTarif());
                     $em->persist($payer);
                     $num= $this->getRepo('Reservation')->getDernierNumPlace($res->getDepart());
                            $num=$num+1;
                            $res->setNumPlace($num);
                    }
                    $em->persist($res);

                    $em->flush();
                    if(!is_null($ancien_num) && $ancien_num!=$res->getNumPlace())
                    {
                        $notif="Cher client! Suite � la modification de votre r�servation, votre num�ro de place a chang�. Votre avez le num�ro ".$res->getNumPlace()." sur le d�part: ".$res->getDepart()->getLibelle()."";
                         SMSSender::send($res->getClient()->getTel(), $notif);
                    }
                    $this->msg="Les modifications sont enregsitr�es avec succ�s!";
        return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig', 'msg'=>$this->msg));
        }else
        {
            return $this->render('GOCaravaneBundle:Reservation:_edit_form.html.twig', array('res'=>$res,'form'=>$resForm->createView()));
     
        }
    }
    public function confirmAction(Request $req)
    {
        $ResRepo=$this->getRepo('Reservation');
        $res=$ResRepo->find($req->get('id_res'));
        $res->setConfirme(true);
        $em=$this->getDoctrine()->getManager();
        $em->persist($res);
        $em->flush();
       // $msg="R�servation confirm�e!";
        $this->msg="R�servation confirm�e avec succ�s!";
         return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig', 'msg'=>$this->msg));
        
    }
    //======FONCTIONPOUR SELECTIONNER LA LISTE DES INSCRITS POUR UN DEPART DONNE
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("liste/index", name="go_caravane_reservation_liste_index")
     * @Route("liste/{id}", name="go_caravane_reservation_liste_show")
     */
    public function showAction(Request $req, Depart $depart=null)
    {
         $ResRepo=$this->getRepo('Reservation');
        $depRepo=$this->getRepo('Depart');
        $listeRes=$ResRepo->getListeRes($depart);
        if(!empty($depart))
        {
            if($req->isXmlHttpRequest())
            {
                if($depart->getTrajet()==1)
                    return $this->render('GOCaravaneBundle:Reservation:liste_ugb.html.twig', array("liste"=>$listeRes, "depart"=>$depart));
                    else if($depart->getTrajet()==2)
                    return $this->render('GOCaravaneBundle:Reservation:liste_dakar.html.twig', array("liste"=>$listeRes, "depart"=>$depart));
        
            }
                else
                 return $this->render('GOCaravaneBundle:Reservation:liste_index.html.twig', array("liste"=>$listeRes, "depart"=>$depart));
        }
        return $this->render('GOCaravaneBundle:Reservation:liste_index.html.twig');
       
    }
    //======FONCTION POUR EXPORTER LA LISTE DES INSCRITS POUR UN DEPART DONNE
    /**
     * 
     * @param Request $req
     * @Route("export_all_res_en_cours.golob",name="export_all_res");
     * @Secure(roles="ROLE_SUP_CARAV");
     */
    public function exportAllResEnCoursAction(Request $req)
    {
        /* Cette fonction permet d'exporter la liste des r�servations sur un d�part donn� selon le format
        choisi, soit en PDF soit au format texte         */
        
        $ResRepo=$this->getRepo('Reservation');
        $listeRes=$ResRepo->getAll();
        $depRepo=$this->getRepo('Depart');
        // R�cup�ration de la liste des inscrits
        if($req->get('filter')==Cons::PAYE)
        $listeRes=$ResRepo->getAllResEnCours();
        else
        
       //Instantitiation des classes qui g�renet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
       
       
        //SI le format choisi est PDF 
        if(strtolower($req->get('format'))=="pdf")
        {//d�claration de la variable de base, � laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite pass� � la fonction qui exporte les donn�es, laquelle fonction prend en parametre
            //un tableau et non des objets
            $donnees=array();
            
        foreach($listeRes as $res)
        {
            $client=$res->getClient();
            $paye_par="";
            $code_recu="";
            $paye=$res->getPaiement();
              if(!empty($paye))
            {
                $paye_par=$paye->getAgent()->getPrenom();
                $code_recu=$paye->getCodeRecu();
            }
            $agent="";
            if(!empty($res->getAgent()))
            $agent=$res->getAgent()->getPrenom();
            $arr=array($code_recu,$client->getPrenom(). ' '.$client->getNom(), 
                $client->getTel(),
                $res->getPointDep()->getNom(),
                $res->getDes()->getLibelle(),
                $agent,
               $paye_par
                
                );
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //d�finition des colonnes du tableau
        $columns=array(
            array("name"=>"Code", "width"=>15),
            array("name"=>"Client", "width"=>45),
            array("name"=>"T�l�phone", "width"=>40),
            array("name"=>"Point dep", "width"=>20),
            array("name"=>"Des", "width"=>20),
            array("name"=>"inscrit par", "width"=>20),
            array("name"=>"Pay�", "width"=>20)); 
        // d�clarion des variables pour le fichier de sortie
        $filename="Liste D�part ".$depart->getLibelle().'.txt'; $titre="Liste des inscrit pour la caravane ".$depart->getLibelle();
        //Exporter les donn�es
        $tableExpoPDF->export($donnees, $columns, $filename, $titre);
        }
        //if(strtolower($req->get('format'))=="text")
        else{
        ////d�claration de la variable de base, � laquelle nous ajouterons les objets sous forme de text
            //Cette variable sera ensuite pass�e � la fonction qui exporte les donn�es, laquelle fonction prend en parametre
            //string et  non des objets
         
        $donnees_text='';
        foreach($listeRes as $res)
        {
             $client=$res->getClient();
             //===d�terminer l'heure du d�part selon l'horaire, fonction variable selon l'horraire du d�part
        $houer_functions=array("",'getHeurePointDep', 'getHeurePointDepSoir');
        $heur_function=$houer_functions[$res->getDepart()->getHoraire()];
           
                    $donnees_text.=$client->getPrenom(). ' '.$client->getNom()." \t "
                    .$client->getTel()." \t "
                    .$res->getPointDep()->getNom()." \t"
                    .$res->getDepart()->getLibelle()." \t"
                    .$res->getDepart()->getDate()->format('d/m/Y')." \t"
                            .$res->getPointDep()->$heur_function()->format('H\h:i')." \t"
                    .$res->getPointDep()->getArretBus()."\r\n";
        
         }
        
         $filename="Liste des ttes les r�servations .txt"; $titre="Liste de tous les inscrits";
         $tableExpoText->export($donnees_text, $filename);
        }
           
        
    }
    /**
     * 
     * @param Request $req
     * @Route("list/export/{id}/{filter}/{format}",name="go_caravane_reservation_liste_export")
   */
    public function exportAction(Request $req, Depart $depart)
    {
        /* Cette fonction permet d'exporter la liste des r�servations sur un d�part donn� selon le format
        choisi, soit en PDF soit au format texte         */
         $donnees=array();
           $columns=array();
        $ResRepo=$this->getRepo('Reservation');
        $depRepo=$this->getRepo('Depart');
        // R�cup�ration de la liste des inscrits
        if($req->get('filter')==Cons::PAYE)
        $listeRes=$ResRepo->getListePayesRes($depart,Cons::PAYE);
        elseif($req->get('filter')==Cons::NON_PAYE)
        $listeRes=$ResRepo->getListePayesRes($depart,Cons::NON_PAYE);
        else
        $listeRes=$ResRepo->getListRes($depart);
       //Instantitiation des classes qui g�renet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
         //SI le format choisi est PDF 
        if(strtolower($req->get('format'))=="pdf")
        {//d�claration de la variable de base, � laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite pass� � la fonction qui exporte les donn�es, laquelle fonction prend en parametre
            //un tableau et non des objets
           
          
            if($depart->getTrajet()==Cons::DAKAR_UGB)
            {
                foreach($listeRes as $res)
                 {
                    $client=$res->getClient();
                    $paye_par="";
                    $code_recu="";
                    $paye=$res->getPaiement();
                    if(!empty($paye))
                    {
                        $paye_par=$paye->getAgent()->getPrenom();
                        $code_recu=$paye->getCodeRecu();
                    }
                        $agent="";
                        if(!empty($res->getAgent()))
                        $agent=$res->getAgent()->getPrenom();
                        else
                            $agent="En ligne";
                        $arr=array('',$client->getPrenom(). ' '.$client->getNom(), 
                            substr($client->getTel(),-9,9),
                            $res->getPointDep()->getNom(),
                            $res->getHeureDepart()->format('H\h:i'),
                            $agent,);
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //d�finition des colonnes du tableau
        $columns=array(
            array("name"=>"Conf", "width"=>8),
            array("name"=>"Client", "width"=>50),
            array("name"=>"T�l�phone", "width"=>25),
            array("name"=>"P dep", "width"=>40),
            array("name"=>"Heure", "width"=>20),
            array("name"=>"inscrit par", "width"=>20),
            ); 
            }
            elseif($depart->getTrajet()==Cons::UGB_DAKAR)
            {
            
        foreach($listeRes as $res)
        {
            $client=$res->getClient();
            $paye_par="";
            $code_recu="";
            $paye=$res->getPaiement();
            if(!empty($paye))
            {
                $paye_par=$paye->getAgent()->getPrenom();
                $code_recu=$paye->getCodeRecu();
            }
            $agent="";
            if(!empty($res->getAgent()))
            $agent=$res->getAgent()->getPrenom();
            $arr=array($res->getNumPlace(),$code_recu,$client->getPrenom(). ' '.$client->getNom(), 
                $client->getTel(),
                $res->getPointDep()->getNom(),
                $res->getDes()->getLibelle(),
                $agent,
               $paye_par
                
                );
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //d�finition des colonnes du tableau
        $columns=array(
            array("name"=>"Place", "width"=>8),
            array("name"=>"Code", "width"=>20),
            array("name"=>"Client", "width"=>50),
            array("name"=>"T�l�phone", "width"=>25),
            array("name"=>"P dep", "width"=>20),
            array("name"=>"Des", "width"=>20),
            array("name"=>"inscrit par", "width"=>20),
            array("name"=>"Pay�", "width"=>20)); 
            }   
        // d�clarion des variables pour le fichier de sortie
        $filename="Liste D�part ".$depart->getLibelle().'-'; $titre="Liste des inscrit pour la caravane ".$depart->getLibelle();
        //Exporter les donn�es
        $tableExpoPDF->export($donnees, $columns, $filename, $titre);
    }
        if(strtolower($req->get('format'))=="text")
        {
        ////d�claration de la variable de base, � laquelle nous ajouterons les objets sous forme de text
            //Cette variable sera ensuite pass�e � la fonction qui exporte les donn�es, laquelle fonction prend en parametre
            //string et  non des objets
         
        $donnees_text='';
        foreach($listeRes as $res)
        {
             $client=$res->getClient();
                    $donnees_text.=$client->getPrenom(). ' '.$client->getNom()." \t "
                    .$client->getTel()." \t "
                    .$res->getNumPlace()." \t "
                    .$res->getPointDep()->getNom()." \t"
                            .$res->getHeureDepart()->format('H\h:i')." \t"
                    .$res->getArretBus()."\r\n";
        
         }
        
         $filename="Liste D�part ".$depart->getLibelle().'.txt'; $titre="Liste des inscrits pour la caravane ".$depart->getLibelle();
         $tableExpoText->export($donnees_text, $filename);
        }
           
        
    }
    protected function payer(Reservation $res)
    {
                $em=$this->em();
                $paye=new Payer(); 
               $User= $this->getUser();
               if($this->isOnline())
                   $User= $this->getRepo ('User')->find(3);
               $code=$User->getId().$res->getId();
                if($this->isOnline())
                    $code="11".$code;
                $paye->setCodeRecu(intval($code));
                $paye->setAgent($User);
                $paye->setMontant($res->getDes()->getTarif());
                $paye->setDate(new \DateTime());
                $res->setConfirme(true);
                $res->setPaye(true);
                $res->setPaiement($paye);
                $paye->setRes($res);
                
                $em->persist($paye);
                $em->flush();
                $res->setPaiement($paye);
                $em->persist($res);
                try
                {
                    $em->flush();
                
               
               return $paye->getCodeRecu();
                }catch(\Exception $e)
                {
                    echo $e->getMessage();
                }
               
    }
    //-------------------------Recherches 
    public function historiqueVoyageAction(Request $req)
    {
        $liste_voyages=$this->getRepo('Reservation')->historiqueVoyage($req->get('tel'));
        //$liste_voyages=$this->getRepo('Reservation')->getDernierVoyage($req->get('tel'));
        
        $client=$this->getRepo('Client')->findOneByTel($req->get('tel'));
        $nombre_voyage=count($liste_voyages);
        
        return $this->render('GOCaravaneBundle:Client:historique_voyage.html.twig',
            array (
                "liste_voyages"=>$liste_voyages,
                "client"=>$client,
                "nombre_voyage"=>$nombre_voyage
                )
                );
        
    }
    public function getHistoriqueReservationsAction(Request $req)
    {
        $liste_voyages=$this->getRepo('Reservation')->historiqueReservations(Cons::EVENT, $req->get('data'));
        //$liste_voyages=$this->getRepo('Reservation')->getDernierVoyage($req->get('tel'));
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
        $donnees_text='';
        foreach($liste_voyages as $res)
        {
             $client=$res->getClient();
                    $donnees_text.=$client->getPrenom(). ' '.$client->getNom()." \t "
                    .$client->getTel()." \t "
                    .$res->getPointDep()->getNom()." \t"
                    .$res->getDepart()->getLibelle()."\t"
                    .$res->getDate()->format('d/m/Y')."\r\n";
        
         }
        
         $filename='Liste inscrits event D�part .txt'; $titre="Liste des inscrit pour la caravane ";
         $tableExpoText->export($donnees_text, $filename);
        
    }
    
    public function getVoyageEnCoursAction(Request $req)
    {
        $voyage=$this->getRepo('Reservation')->getDernierVoyage($req->get('tel'));
        
        $client=$this->getRepo('Client')->findOneByTel($req->get('tel'));
        //$nombre_voyage=count($liste_voyage);
        //$voy_json=array("depart"=>$voyage->getDepart()->getLibelle(), "destination"=>$voyage->getDes()->getLibelle());
        
        //var_dump(json_encode($voy_json));die();
        return $this->render('GOCaravaneBundle:Reservation:res_en_cours_ugb.html.twig',
            array (
                "res"=>$voyage,
                //"res1"=>$voy_json,
                "client"=>$client
                )
                );
        
    }
    //====================================Chiffres============================
    public function  indexChiffreAction()
    {
        //var_dump($this->getUser()->getId()); die();
        $User=$this->getRepo('User');
        $Depart=$this->getRepo('Depart');
        $Payer=$this->getRepo('Payer');
        $users=$User->getListeUsers();
        $departs= $Depart->getListeDeparts()->getQuery()->getResult();
        $chiffres=array();
        foreach($departs as $depart)
        {
          $ar=array(
              'depart'=>$depart, 
              'total'=>(int) $Payer->getTotalPayeDepart($depart->getId()),
               'nombre_thies'=>$Payer->getNombrePaye(Cons::DEPART,$depart->getId(),'',\GO\CaravaneBundle\Utils\Constants::DESTINATION_THIES),
              'nombre_dakar'=>$Payer->getNombrePaye(Cons::DEPART,$depart->getId(), '',\GO\CaravaneBundle\Utils\Constants::DESTINATION_DAKAR)
               ) ;
          array_push($chiffres, $ar);
        }
        
        return $this->render('GOCaravaneBundle:Chiffre:chiffre_index.html.twig', array('chiffres'=>$chiffres, 'event'=> $this->getRepo('Evenement')->getEventsEncours()->getQuery()->getResult()[0]));
    }
    public function  chiffreDepartAction(Request $req)
    {
        //var_dump($this->getUser()->getId()); die();
        $User=$this->getRepo('User');
        $Payer=$this->getRepo('Payer');
        $users=$User->getListeUsers(ConsUser::ACTIVE_USERS);
        $chiffres=array();
        foreach($users as $user)
        {
            //V�rifie si l'utilisateur a access � l'application caravane
            //if($user->hasApp('APP_CARAVANE'))
            //On cr�e cette condition pour garder la structure du code/ On va d�commenter la ligne en haut 
            if(1<2)
            {
          $ar=array(
              'user'=>$user, 
              'total'=>(int) $Payer->getTotalPayeUser($user->getId(), $req->get('id_dep')),
               'nombre_thies'=>$Payer->getNombrePaye(Cons::USER,$user->getId(),$req->get('id_dep'),Cons::DESTINATION_THIES),
              'nombre_dakar'=>$Payer->getNombrePaye(Cons::USER, $user->getId(), $req->get('id_dep'),Cons::DESTINATION_DAKAR)
               ) ;
          array_push($chiffres, $ar);
             }
        }
        
        return $this->render('GOCaravaneBundle:Chiffre:chiffre_depart.html.twig', array('chiffres'=>$chiffres));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("chiffre_event-{id}.golob", name="chiffre_event_all")
     */
    public function  chiffreEventAction(Evenement $event,Request $req)
    {
        //var_dump($this->getUser()->getId()); die();
        $User=$this->getRepo('User');
        $Payer=$this->getRepo('Payer');
        $users=$User->getListeUsers(ConsUser::ACTIVE_USERS);
        $chiffres=array();
        foreach($users as $user)
        {
            //V�rifie si l'utilisateur a access � l'application caravane
            //if($user->hasApp('APP_CARAVANE'))
            //On cr�e cette condition pour garder la structure du code/ On va d�commenter la ligne en haut 
            if(1<2)
            {
          $ar=array(
              'user'=>$user, 
              'total'=>(int) $Payer->getTotalPayeEvent($event, $user),
               'nombre_thies'=>$Payer->getNombrePaye(Cons::USER,$user->getId(),$event,Cons::DESTINATION_THIES),
              'nombre_dakar'=>$Payer->getNombrePaye(Cons::USER, $user->getId(), $event,Cons::DESTINATION_DAKAR)
               ) ;
          array_push($chiffres, $ar);
             }
        }
        
        return $this->render('GOCaravaneBundle:Chiffre:chiffre_depart.html.twig', array('chiffres'=>$chiffres));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("chiffre_user-{id}.golob", name="chiffre_user_all")
     */
    public function  chiffreUserAction(Request $req, Evenement $event)
    {
        //var_dump($this->getUser()->getId()); die();
        $User=$this->getRepo('User');
        $Payer=$this->getRepo('Payer');
        $user= $this->getUser();
        $chiffres=array();
        $departs= $this->getRepo('Depart')->getDepartsEvent($event);
        foreach($departs as $depart)
        {
            //V�rifie si l'utilisateur a access � l'application caravane
            //if($user->hasApp('APP_CARAVANE'))
            //On cr�e cette condition pour garder la structure du code/ On va d�commenter la ligne en haut 
          $ar=array(
              'depart'=>$depart,
              'user'=>$user, 
              'total'=>(int) $Payer->getTotalPayeUser($user->getId(), $depart),
               'nombre_thies'=>$Payer->getNombrePaye(Cons::USER,$user->getId(),$depart,Cons::DESTINATION_THIES),
              'nombre_dakar'=>$Payer->getNombrePaye(Cons::USER, $user->getId(), $depart,Cons::DESTINATION_DAKAR)
               ) ;
          array_push($chiffres, $ar);
           
        }
        
        return $this->render('GOCaravaneBundle:Chiffre:chiffre_user.html.twig', array('chiffres'=>$chiffres));
    }
    protected function attribuerNumPlace(Reservation $res)
    {
          $num= $this->getRepo('Reservation')->getDernierNumPlace($res->getDepart());
          
               $num_place_vide=$this->getRepo('Reservation')->getPremierePlaceVide($res->getDepart());
            if($num_place_vide==null)
            {
                        if($num<69)
                {
                $num=$num+1;
                $res->setNumPlace($num);
                }else
                        return "Erreur: toutes les places sont occup�es pour le(s) bus du d�part ".$res->getDepart()->getLibelle();
             }
             else{
                  $res->setNumPlace($num_place_vide);
                 }
                
                try
                {
                    $this->save($res);
                    
                     return $res;
                }catch(\Exception $e)
                {
                    echo $e->getMessage();
                    return false;
                }
    }
    protected function getNotificationMessage(Reservation $res)
    {
        $notification="";
        $heure_rv=$res->getHeureDepart()->format('H\h:i');
        $num_place=null;if($res->isPaye())$num_place="Num�ro Place: <".$res->getNumPlace().">";
        $salutation="Bnjr"; if(intval(\Date('H'))>=16)$salutation="Bnsoir";

                            $pointDep=$res->getPointDep();
                            $arret=$pointDep->getArretBus();
                            $client=$res->getClient();
                            $depart=$res->getDepart();
                             $tel=$client->getTel();
                             $client_data=$client->getPrenomAbrege()." ".$client->getNom();
                             //pr�parer la notification � envoyer au client apr�s r�servation r�uissi
                             $notification=$salutation."! ".$client_data."! "
                                    . "R�servation � la caravane Golob1 "
                                    .$depart->getLibelle()." enregistr�e! RV: "
                                   .$heure_rv. '-'.$res->getPointDep()->getNom().'/ '.$arret.' /'.$num_place;
                          if(strlen($notification)>160)
                           {
                               return substr($notification, 0, 156).'...';
                           }
                           return  $notification;
    }


    /**
     * @Route("online_payer-{id}.golob", name="payer_online")
     */
    public function payerOnlineAction(Reservation $res,Request $req)
    {
       $Paiement=new OrangeMoneyPayment();
      // $Paiement->setReturnUrl($this->generateUrl("payer_online_success"));
       $Paiement->setReturnUrl("http://www.golobone.net/payer_online_success.golob");
       if($this->getUser()==null)
       {
       $Paiement->setReturnUrl("http://www.golobone.net/RES_ONLINE/web/payer_online_success.golob");
       }
       
       $link= $Paiement->facturer($res);
       //var_dump($Paiement);exit();
       return $this->redirect($link);
       }
    /**
     * @Route("online_pay_callback.golob", name="payer_online_callback")
     */
    public function payerOnlineCallBackAction(Request $req)
    {$em= $this->em();
    //exit("you are here without lohin");
       $data=$req->get('data');
       $token=$data['invoice']['token'];
       $id_res=$data['custom_data']['id_res'];
        $Paiement=new OrangeMoneyPayment();
       $facture= $Paiement->test();
        $facture->confirm($token);
        //$client->setPrenom("Prenom Test APN")->setNom("Ttest APIN")->setTel(773300808)->setDate(new \DateTime());
       //$em->persist($client);
       //$em->flush();
      /* $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
            $filename="resutats_test_inp.txt";
            
            //$tableExpoText->export($result, $filename);*/
        if($facture->getStatus()=="completed")
       {
           //$client->setPrenom("Prenom Test APN 2 ")->setNom("Ttest APIN 2")->setTel(773300807)->setDate(new \DateTime());
           //$em->persist($client);
       //$em->flush();
            $res= $this->getRepo('Reservation')->find(intval($id_res));
            if(!is_null($res))
            {
            $this->payer($res);
            $this->attribuerNumPlace($res);
            $msg="Le paiement de votre r�servation par OM a �t� enregistr� avec succ�s!";
            $heure_rv=$res->getHeureDepart()->format('H\h:i');
            $num_place=null;
                if($res->isPaye())$num_place=$res->getNumPlace();
                {
                $notification='Apr�s paiement par OM, votre num�ro de place est le N�'.$num_place.'", RV '.$heure_rv;
                SMSSender::send(substr($res->getClient()->getTel(),-9,9), $notification);
                }
            return $this->sendResponse(array("msg"=>"Op�ration r�ussi"));
            }
       }
       
       }
    /**
     * @Route("payer_online_success.golob", name="payer_online_success")
     */
    public function payerOnlineSuccessAction(Request $req)
    {
        $em= $this->em();
       $token=$req->get('token');
        $Paiement=new OrangeMoneyPayment();
       $facture= $Paiement->test();
        $facture->confirm($token);
       if($facture->getStatus()=="completed")
       {
            $id_res=$facture->getCustomData("id_res");
            $res= $this->getRepo('Reservation')->find($id_res);
            $msg="Le paiement de votre r�servation par OM a �t� enregistr� avec succ�s!";
            return $this->render('GOCaravaneBundle::layout.html.twig', array("msg"=>$msg, "res"=>$res));
       }
       exit("facture non pay�e");
      return $this->render('GOCaravaneBundle:Reservation:payer_online.html.twig', array("link"=>$link));
    }
    protected function isOnline()
    {
        return is_null($this->getUser());
    }

    /**
     * @Route("test_function", name="test_dep")
     */
    public function testAction()
    {
        $client= $this->getRepo('Reservation')->find(50778);
        $notif="test test";
        $tel=773300853;
        
        $r=SMSSender::send($tel, $notif);
        
        var_dump($r);
       exit();
    }
//END OF class
}
