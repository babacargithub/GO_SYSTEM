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
    public function getDetailsAction(Request $req)
    {
        $client=$this->getRepo('Client')->findOneByTel($req->get('tel'));
        //$client=$this->getRepo('Client')->getDetailsClient();
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
            $batchSize = 20;
               $em= $this->em();
$clients=
array(
 array("Hawa Harouna","BA",784010590,1,5,"P29"
),
 array("Houleye","BA",773974070,1,5,"P29"
),
 array("Elisabeth Vanessa Danti","BASSECK",774899108,1,5,"P29"
),
 array("Diabou","BESSANE",772275125,1,5,"P29"
),
 array("Adja Awa","BEYE",778680387,1,5,"P29"
),
 array("Khady Ndongo","CISSE",774960121,1,5,"P29"
),
 array("Moustapha","DIACK",782422920,1,5,"P29"
),
 array("Marieme","DIALLO",782644361,1,5,"P29"
),
 array("Yaye Coumba","DIALLO",778706767,1,5,"P29"
),
 array("Ousmane","DIALLO",706534988,1,5,"P29"
),
 array("Boubacar","DIAME",775204589,1,5,"P29"
),
 array("Mbathio","DIENG",776602182,1,5,"P29"
),
 array("Mane Nar","DIONE",763401932,1,5,"P29"
),
 array("Jean Gabriel","DIONE",776965106,1,5,"P29"
),
 array("Saliou","DIOUF",766154134,1,5,"P29"
),
 array("Henri Samba","DIOUF",776254892,1,5,"P29"
),
 array("Adja Fatou","DOUCOURE",773489169,1,5,"P29"
),
 array("Mouhamed","FALL",778217328,1,5,"P29"
),
 array("Mouhamadou Mangue","FAYE",773538827,1,5,"P29"
),
 array("Ramatoulaye","GNING",771001165,1,5,"P29"
),
 array("Ousseynou","GUEYE",784178843,1,5,"P29"
),
 array("Ndeye Gnagna","KANE",784859448,1,5,"P29"
),
 array("Aminata","KONTA",782868607,1,5,"P29"
),
 array("Matar","LOUM",785391644,1,5,"P29"
),
 array("Guy Youga","MBAYE",772521960,1,5,"P29"
),
 array("Assa Marie","MONTEIL",776410954,1,5,"P29"
),
 array("David","NABE",774913333,1,5,"P29"
),
 array("Desiree Dior","NDIAYE",773281742,1,5,"P29"
),
 array("Ndeye Fatou","NDIAYE",771088083,1,5,"P29"
),
 array("Abdou Aziz","NDIAYE",779907586,1,5,"P29"
),
 array("Fatoumata","NDIAYE",776810980,1,5,"P29"
),
 array("Tabaski","NDOUR",784641160,1,5,"P29"
),
 array("Daouda","NDOUR",767231253,1,5,"P29"
),
 array("Sokhna Maty","NDOYE",783148169,1,5,"P29"
),
 array("Ousmane","NIANG",777572706,1,5,"P29"
),
 array("Ibrahima","NIANG",784043795,1,5,"P29"
),
 array("Moustapha","PENE",784311565,1,5,"P29"
),
 array("Fallou","SARR",766535867,1,5,"P29"
),
 array("Josephine Dibor","SARR",778636592,1,5,"P29"
),
 array("Khady","SARR",784953981,1,5,"P29"
),
 array("Josephine Amy","SARR",778652727,1,5,"P29"
),
 array("Mame Fama","SECK",772660725,1,5,"P29"
),
 array("Ndeye Rokhaya","SECK",781151526,1,5,"P29"
),
 array("Mamadou","SEIDY",778703406,1,5,"P29"
),
 array("El Hadji Mor","SEYE",771083410,1,5,"P29"
),
 array("Mbaye","SOW",773248505,1,5,"P29"
),
 array("Salamata Oumar","SOW",782941546,1,5,"P29"
),
 array("Seydina Mouhamed","SYLLA",777080077,1,5,"P29"
),
 array("Yakouba","THIAM",770841184,1,5,"P29"
),
 array("Lamine Mafane","THIAW",774721037,1,5,"P29"
),
 array("Adama","AW",785075979,1,3,"P29"
),
 array("Abdoul Aziz","AW",771558537,1,3,"P29"
),
 array("Dieynaba","BASSOUM",779702292,1,3,"P29"
),
 array("Aissatou Djilene","CISS",782628220,1,3,"P29"
),
 array("Al Hadji Daouda","COLY",785407999,1,3,"P29"
),
 array("Bineta","DIA",779502604,1,3,"P29"
),
 array("Diary","DIA",778422624,1,3,"P29"
),
 array("Ndeye Astou","DIAGNE",772312155,1,3,"P29"
),
 array("Pathe","DIAKHATE",778683275,1,3,"P29"
),
 array("Sassoum","DIAKHATE",784535072,1,3,"P29"
),
 array("Ami","DIALLO",776529337,1,3,"P29"
),
 array("Ismaila","DIALLO",782200949,1,3,"P29"
),
 array("Mamadou","DIAWO",779118319,1,3,"P29"
),
 array("Marie","DIENE",784427452,1,3,"P29"
),
 array("Korka","DIENG",783783295,1,3,"P29"
),
 array("Oulimata","DIEYE",775783486,1,3,"P29"
),
 array("Khady","DIOP",774526498,1,3,"P29"
),
 array("Fallou","DIOUF",765625404,1,3,"P29"
),
 array("Sokhna Aissatou","DIOUF",784912722,1,3,"P29"
),
 array("Mariama","DIOUF",781754260,1,3,"P29"
),
 array("Dial","FALL",765058602,1,3,"P29"
),
 array("Ousmane Diene","FAYE",764603739,1,3,"P29"
),
 array("Adiaratou Oumou Kaltom","GAYE",781424327,1,3,"P29"
),
 array("Xavier Frederico","GOMIS",774711189,1,3,"P29"
),
 array("Louis Simon","GOMIS",777436355,1,3,"P29"
),
 array("Serigne Babacar","KHOULE",783016580,1,3,"P29"
),
 array("Demba","MANE",781732212,1,3,"P29"
),
 array("Saliou","MBALLO",706526796,1,3,"P29"
),
 array("Modou Sow","MBAYE",783463246,1,3,"P29"
),
 array("Fatou","MBOUP",781808466,1,3,"P29"
),
 array("Souleymane","NDIAYE",776854698,1,3,"P29"
),
 array("Aminata Mohammad","NDIAYE",784480005,1,3,"P29"
),
 array("Adja Sophie","NDIAYE",778385656,1,3,"P29"
),
 array("Modou","NDIAYE",784638378,1,3,"P29"
),
 array("Ibrahima","NDOUR",781461343,1,3,"P29"
),
 array("Salimata","NDOUR",773041952,1,3,"P29"
),
 array("Ndama","NGOM",783013642,1,3,"P29"
),
 array("Mouhamed","NIANG",784730538,1,3,"P29"
),
 array("Ramata","POLANE",772597576,1,3,"P29"
),
 array("Fatou","SAMB",771058093,1,3,"P29"
),
 array("Aboubacry","SARR",782550942,1,3,"P29"
),
 array("Ndeye Khady","SARR",771122082,1,3,"P29"
),
 array("Alassane","SARR",785758897,1,3,"P29"
),
 array("Aliou Sow","SECK",771341796,1,3,"P29"
),
 array("Awa","SY",781756988,1,3,"P29"
),
 array("Amy","WADE",705037189,1,3,"P29"
),
 array("Djibril","BADJI",782830698,1,4,"P29"
),
 array("Mama Yero","BALDE",777761536,1,4,"P29"
),
 array("Marietou","BODIAN",774942180,1,4,"P29"
),
 array("Alexis Badiane","COLY",779085192,1,4,"P29"
),
 array("Florentine","DASYLVA",771860473,1,4,"P29"
),
 array("Khoudia","DIA",781726957,1,4,"P29"
),
 array("Mamadou Yacine","DIALLO",770773584,1,4,"P29"
),
 array("El Hadji Boubacar","DIALLO",782432337,1,4,"P29"
),
 array("Justin Andio","DIATTA",777768593,1,4,"P29"
),
 array("Adja Adama","DIEME",782695232,1,4,"P29"
),
 array("Coura","DIENG",774097062,1,4,"P29"
),
 array("Magatte","DIENG",783435483,1,4,"P29"
),
 array("Pape Mamadou","DIOP",770661313,1,4,"P29"
),
 array("Thiane","DIOUF",784598159,1,4,"P29"
),
 array("Antoine Thierno","DIOUF",776362495,1,4,"P29"
),
 array("Mareme Maty","DIOUM",774280482,1,4,"P29"
),
 array("Lanla","DJITTE",783685276,1,4,"P29"
),
 array("Mouhamadou","FALL",774584755,1,4,"P29"
),
 array("Khady","FALL",774947850,1,4,"P29"
),
 array("Birama","FALL",770483041,1,4,"P29"
),
 array("Fatou","FALL",785841917,1,4,"P29"
),
 array("Marie Augustine Ndieme","FAYE",784226885,1,4,"P29"
),
 array("Ifra","KA",785954864,1,4,"P29"
),
 array("Ndeye Awa","KANE",771740715,1,4,"P29"
),
 array("Oulimata","KANE",775710710,1,4,"P29"
),
 array("Ousmane","KEBE",784844295,1,4,"P29"
),
 array("Ibrahima","KEBE",784168782,1,4,"P29"
),
 array("Imam Assane","KEBE",783899930,1,4,"P29"
),
 array("Ndeye Sokhna","LO",776659839,1,4,"P29"
),
 array("Safietou","MBAYE",782335531,1,4,"P29"
),
 array("Ndeye Daro","MBODJ",781615221,1,4,"P29"
),
 array("Michel","MENDY",777962379,1,4,"P29"
),
 array("Juvenale Cyril","NADIELIN",779752291,1,4,"P29"
),
 array("Roky","NDAO",777660730,1,4,"P29"
),
 array("Seynabou","NDIAYE",785581321,1,4,"P29"
),
 array("Marema","NDOYE",775891289,1,4,"P29"
),
 array("Germaine","NGOM",782930916,1,4,"P29"
),
 array("Babacar","NIANG",784879020,1,4,"P29"
),
 array("Fatoumata Binetou","SARR",781870140,1,4,"P29"
),
 array("Aliou Maty","SECK",784383400,1,4,"P29"
),
 array("Bilal Alain","SENE",781715897,1,4,"P29"
),
 array("Saliou Guedji","SENE",768612470,1,4,"P29"
),
 array("Babacar","SOUKOUNA",775580105,1,4,"P29"
),
 array("Aminata","SOW",778462332,1,4,"P29"
),
 array("Ablaye","SY",782172160,1,4,"P29"
),
 array("Ibrahima","THIAM",779432752,1,4,"P29"
),
 array("Ousseynou","THIAM",785287742,1,4,"P29"
),
 array("Ireine Coumba","TOURE",785198523,1,4,"P29"
),
 array("Joseph Viany","COLY",774301743,7,19,"P29"
),
 array("Ibrahima","COULIBALY",784409509,7,19,"P29"
),
 array("Malick","DIACK",776963204,7,19,"P29"
),
 array("Mariama","DIAKHATE",779153422,7,19,"P29"
),
 array("Marie","DIASSY",771704576,7,19,"P29"
),
 array("Younouss Jules Pintedie","DIATTA",777080352,7,19,"P29"
),
 array("Mouhamadou Moustapha","DIAW",773349941,7,19,"P29"
),
 array("Khady Ousmane","DIENG",774541391,7,19,"P29"
),
 array("Modou","DIENG",777904087,7,19,"P29"
),
 array("Ousseynou","DIOP",707752564,7,19,"P29"
),
 array("Fallou","DIOP",771097625,7,19,"P29"
),
 array("Diegane","DIOUF",785438142,7,19,"P29"
),
 array("Makhtar","DRAME",782609814,7,19,"P29"
),
 array("Baye Dame","FALL",771992987,7,19,"P29"
),
 array("Papa Saliou","FALL",771996674,7,19,"P29"
),
 array("Mohamed Fadel","FALL",781507633,7,19,"P29"
),
 array("Ibrahima","FALL",782940999,7,19,"P29"
),
 array("Khadidiatou Moussa","FALL",783002748,7,19,"P29"
),
 array("Khadim","FAYE",773014270,7,19,"P29"
),
 array("Ernest Cedric Celestin","FAYE",777226871,7,19,"P29"
),
 array("Aby","FAYE",785949801,7,19,"P29"
),
 array("Omar","FAYE",763224207,7,19,"P29"
),
 array("Mouhamed","GAYE",782912717,7,19,"P29"
),
 array("Ndeye Fatou","GUEYE",772132837,7,19,"P29"
),
 array("Seydina Oumar","GUEYE",778238975,7,19,"P29"
),
 array("Idrissa","HOTT",762965038,7,19,"P29"
),
 array("Cheikh","KHOUMA",762962574,7,19,"P29"
),
 array("Helene Ponou Djagalou","MALOU",779510712,7,19,"P29"
),
 array("Astou","MBOW",769064104,7,19,"P29"
),
 array("Aby Cheryl Anne","MENDY",776499623,7,19,"P29"
),
 array("Saliou Abou Bakry","NDAO",782564908,7,19,"P29"
),
 array("Maty","NDAO",774775366,7,19,"P29"
),
 array("Yacine","NDIAYE",778753590,7,19,"P29"
),
 array("Saliou","NDIAYE",777858611,7,19,"P29"
),
 array("Abdou Lahat","NDIAYE",781366946,7,19,"P29"
),
 array("Omar","NDIAYE",786338351,7,19,"P29"
),
 array("Mame Fama","NIANG",763610900,7,19,"P29"
),
 array("Fatoumata Bintou","SADIO",785123618,7,19,"P29"
),
 array("Ndeye Rokhaya","SALL",778458996,7,19,"P29"
),
 array("Ndeye Adama","SARR",706450283,7,19,"P29"
),
 array("Ablaye","SARR",782960541,7,19,"P29"
),
 array("Aicha Salimatou","SECK",781241328,7,19,"P29"
),
 array("Fatou Binetou","SECK",783753969,7,19,"P29"
),
 array("Mane","SEYE",777933868,7,19,"P29"
),
 array("Abdoulaye","SEYE",777040622,7,19,"P29"
),
 array("Thierno Idy","THIAM",771503382,7,19,"P29"
),
 array("Amy","TOP",774246209,7,19,"P29"
),
 array("Fama","TOURE",773945723,7,19,"P29"
),
 array("Aissata","AW",782342685,1,2,"P29"
),
 array("Ibrahima","BA",782667533,1,2,"P29"
),
 array("Mamadou Lamine","BADJINKA",771401946,1,2,"P29"
),
 array("Dieyla","CISSE",784474176,1,2,"P29"
),
 array("Ibrahima","COLY",783738454,1,2,"P29"
),
 array("Coumba","COULIBALY",774724236,1,2,"P29"
),
 array("Pape Alioune","DIACK",776330232,1,2,"P29"
),
 array("Mariama Djira","DIAFATE",776580080,1,2,"P29"
),
 array("Fabien Sitolito","DIATTA",763761363,1,2,"P29"
),
 array("Desire Tidiane","DIATTA",770710931,1,2,"P29"
),
 array("Moussa","DIEYE",706426457,1,2,"P29"
),
 array("Abdoulaye","DIONE",763537227,1,2,"P29"
),
 array("Mohamed","DIONE",705488134,1,2,"P29"
),
 array("Cheikh Seydi Khalifa Ababacar","DIONGUE",770921397,1,2,"P29"
),
 array("Arame","DIOP",781206190,1,2,"P29"
),
 array("Fatou","DIOP",784356117,1,2,"P29"
),
 array("Amadou","DIOP",774861118,1,2,"P29"
),
 array("Sokhna Camara Kone","DIOUF",775155298,1,2,"P29"
),
 array("Ndèye","BA",777349636,1,2,"P29"
),
 array("Alhassane","DIOUM",778415795,1,2,"P29"
),
 array("Gnambo","GACKOU",779095123,1,2,"P29"
),
 array("Serigne Modou","GUEYE",785206263,1,2,"P29"
),
 array("Fatimata Bineta","HANNE",772437946,1,2,"P29"
),
 array("Makhtar","KEBE",782340470,1,2,"P29"
),
 array("Bineta","KEBE",771211177,1,2,"P29"
),
 array("Cheikh Tidiane","LAGUE",785837344,1,2,"P29"
),
 array("Abdou Aziz","LOUM",783500550,1,2,"P29"
),
 array("Mamadou","MBAYE",774089877,1,2,"P29"
),
 array("El Hadji Abdoul Aziz","MBAYE",778596571,1,2,"P29"
),
 array("Sidy","NDIAYE",781636693,1,2,"P29"
),
 array("Mama Fatou","NDIAYE",761229880,1,2,"P29"
),
 array("Ndeye Aida","NDIONGUE",770916391,1,2,"P29"
),
 array("Moustapha","NDOYE",773433528,1,2,"P29"
),
 array("Ousseynou","NGOM",771182471,1,2,"P29"
),
 array("Fatou Kine","SALL",777169323,1,2,"P29"
),
 array("Fatou","SALL",783453596,1,2,"P29"
),
 array("Cheikh Mbacke","SAMB",785867287,1,2,"P29"
),
 array("Astou Alabatou","SANE",771927189,1,2,"P29"
),
 array("Khoudia","SARR",781538613,1,2,"P29"
),
 array("Lamine","SARR",783737193,1,2,"P29"
),
 array("Abdourahmane","SECK",772142182,1,2,"P29"
),
 array("Ndeye Anta","SECK",778681455,1,2,"P29"
),
 array("Ndeye Fatou","SECK",777288333,1,2,"P29"
),
 array("Thiamba","SEYE",777250239,1,2,"P29"
),
 array("Haby","SOW",779466183,1,2,"P29"
),
 array("Birame","SOW",776800345,1,2,"P29"
),
 array("Aly","SY",784273845,1,2,"P29"
),
 array("Cheikh Ahmadou Bamba","SYLLA",772711448,1,2,"P29"
),
 array("Al Hassane","TAMBADOU",771267318,1,2,"P29"
),
 array("El Hadji","WADE",776616868,1,2,"P29"
),
 array("Hadijatou","BEYE",776962847,1,1,"P29"
),
 array("Astou","BEYE",761206170,1,1,"P29"
),
 array("Marlene Adelaide Justine","DE SOUZA",771978834,1,1,"P29"
),
 array("Mamadou","DIA",777010809,1,1,"P29"
),
 array("Moustapha BÃ¢","DIAGNE",763435082,1,1,"P29"
),
 array("Ngotty","DIALLO",776052894,1,1,"P29"
),
 array("Amadou","DIALLO",776947354,1,1,"P29"
),
 array("Aissatou","DIAME",203905830,1,1,"P29"
),
 array("Joseph","DIATTA",770793210,1,1,"P29"
),
 array("Serigne Ibrahima","DIAW",783595759,1,1,"P29"
),
 array("Cheikh Tidiane","DIOP",777388356,1,1,"P29"
),
 array("Khady","DIOP",773436617,1,1,"P29"
),
 array("Ngone FAYE","DIOP",771877939,1,1,"P29"
),
 array("Amadou","DIOP",772075360,1,1,"P29"
),
 array("Seynabou Khary Karre","DIOP",785837421,1,1,"P29"
),
 array("Anna Dior","DIOUF",778128926,1,1,"P29"
),
 array("Lamine","DIOUF",766671360,1,1,"P29"
),
 array("Oumy","DJITE",781681961,1,1,"P29"
),
 array("Aicha","FALL",761200947,1,1,"P29"
),
 array("Aliou","FALL",770540732,1,1,"P29"
),
 array("Mouhamadou Bachir","FAYE",777883901,1,1,"P29"
),
 array("Papa Abdou","GASSAMA",772260022,1,1,"P29"
),
 array("Moussa","GAYE",703561118,1,1,"P29"
),
 array("Penda LEA Maria","GNING",777591865,1,1,"P29"
),
 array("Jean Pierre","GNINGUE",781028020,1,1,"P29"
),
 array("Mohamed El Bachir","GUEYE",770385210,1,1,"P29"
),
 array("Cheikh","GUEYE",776891658,1,1,"P29"
),
 array("Adama","GUEYE",781005043,1,1,"P29"
),
 array("Mariama","KA",781115988,1,1,"P29"
),
 array("Diarra","NDIAYE",781382661,1,1,"P29"
),
 array("Cheikh Omar","NDIAYE",771236781,1,1,"P29"
),
 array("Abdoulaye Hamet","NDIAYE",776230522,1,1,"P29"
),
 array("Abdoulaye","NDIAYE",708973157,1,1,"P29"
),
 array("Mouhamadou Moustapha","NDIAYE",771762574,1,1,"P29"
),
 array("Nini","NDIAYE",781426966,1,1,"P29"
),
 array("Mouhamed Rassoul","NDIAYE",772275195,1,1,"P29"
),
 array("Mariama Helene","NDONG",776963961,1,1,"P29"
),
 array("Fatou","NGOM",784088175,1,1,"P29"
),
 array("Tairatou","NGOM",777110595,1,1,"P29"
),
 array("Mamadou","POUYE",783978893,1,1,"P29"
),
 array("Aloise Ephilca","SAGNA",782145020,1,1,"P29"
),
 array("Aminata","SALL",775910831,1,1,"P29"
),
 array("Ndiogop","SALL",781927605,1,1,"P29"
),
 array("Ndeye Awa","SECK",773726446,1,1,"P29"
),
 array("Fatou","SECK",784247232,1,1,"P29"
),
 array("Mouhamed Saloum Sougoufara","SENE",778718749,1,1,"P29"
),
 array("Hakoye","SONKO",784921272,1,1,"P29"
),
 array("Abdou Aziz","SOW",778559094,1,1,"P29"
),
 array("Bassirou","SOW",775327527,1,1,"P29"
),
 array("Tamsir","SYLLA",775840840,1,1,"P29"
),
 array("Cheikh Ahmadou Bamba","THIAM",779277397,1,1,"P29"
),
 array("Ibrahima","THIAM",782562166,1,1,"P29"
),
 array("Cheikhoul Khadim","THIAW",775776173,1,1,"P29"
),
 array("Sokhna Aicha","THIOUNE",774522961,1,1,"P29"
),
 array("Abdou Rahmane","WONE",783936092,1,1,"P29"
),
 array("Thierno Baba Galle","WONE",781048946,1,1,"P29"
),
 array("Afoua Adelaide","AKA",782109138,1,6,"P29"
),
 array("Salif","BA",773813086,1,6,"P29"
),
 array("Fatoumata Bintou","BA",774859849,1,6,"P29"
),
 array("Abdoul Aziz Dabakh","BEYE",782902794,1,6,"P29"
),
 array("Alioune","CISSE",784310180,1,6,"P29"
),
 array("Assietou","CISSE",778884524,1,6,"P29"
),
 array("Khalifa Ababacar","CISSE",777304507,1,6,"P29"
),
 array("Djeynaba Moussa","DEH",771265241,1,6,"P29"
),
 array("Moustapha","DIA",781240967,1,6,"P29"
),
 array("Youma","DIABAKHATE",773717963,1,6,"P29"
),
 array("El Hadji Babacar","DIACK",781066078,1,6,"P29"
),
 array("Amadou Moctar","DIAGNE",777326941,1,6,"P29"
),
 array("Mamadou Wade","DIAGNE",773102122,1,6,"P29"
),
 array("Mariama","DIALLO",777151403,1,6,"P29"
),
 array("Marema","DIALLO",771750608,1,6,"P29"
),
 array("Abou Backre Sadikh","DIARRA",774749485,1,6,"P29"
),
 array("Jean Bernard","DIATTA",784088961,1,6,"P29"
),
 array("Sadio","DIEDHIOU",771076767,1,6,"P29"
),
 array("Sokhna Anta","DIOP",771553277,1,6,"P29"
),
 array("Thierno","DIOP",778416393,1,6,"P29"
),
 array("Ndeye Sophie","DIOP",771251784,1,6,"P29"
),
 array("Paul Ndew","DiOUF",781372908,1,6,"P29"
),
 array("Aissatou","FALL",772662242,1,6,"P29"
),
 array("Mame Fatim","FALL",785086809,1,6,"P29"
),
 array("Mouhamadou Moustapha","FAYE",784287581,1,6,"P29"
),
 array("Ndeye Aissatou","GAYE",771757609,1,6,"P29"
),
 array("Aminata","GUEYE",781544976,1,6,"P29"
),
 array("Ndiaga","KA",776094244,1,6,"P29"
),
 array("Innocence Rokhaya Eugenie","MANCOR",771393448,1,6,"P29"
),
 array("Ndeye Samba","NDIAYE",779735062,1,6,"P29"
),
 array("Khadidiatou","NDIAYE",775606018,1,6,"P29"
),
 array("Elisabeth Francoise Siga","NDIAYE",775219635,1,6,"P29"
),
 array("Yacine","NDOYE",782936958,1,6,"P29"
),
 array("Awa","NGOM",771068854,1,6,"P29"
),
 array("Mouhamadou","NGOM",780103792,1,6,"P29"
),
 array("Jean Paul","PREiRA",785953863,1,6,"P29"
),
 array("Anne Marie Virginie","SAGNA",782772650,1,6,"P29"
),
 array("Kardiatou Samba","SALL",782079557,1,6,"P29"
),
 array("Dieneba","SAMBOU",778628309,1,6,"P29"
),
 array("Khady","SANE",781606478,1,6,"P29"
),
 array("Georgette Regina Betty Salane","SARR",781663928,1,6,"P29"
),
 array("Khady","SEYDI",777502864,1,6,"P29"
),
 array("Astou","SOKHNA",778647414,1,6,"P29"
),
 array("Baidy","SOUMARE",783596693,1,6,"P29"
),
 array("Bineta","SOW",775763319,1,6,"P29"
),
 array("Mamadou","TOURE",786350487,1,6,"P29"
),
 array("Adji Sokhna","TOURE",777979520,1,6,"P29"
));
                foreach ($clients as $i => $item) 
               {
                    $oldClient=$this->getRepo('Client')->findOneByTel($item[2]);
                    if(is_null($oldClient))
                    {       
                            $Client = new Client();
                            $Client->setPrenom($item[0])
                                   ->setNom($item[1])
                                   ->setTel($item[2])
                                   ->setAdresse("UGB")
                                   ->setPromo($item[5])
                                   ->setUfr($em->getRepository("GOMainBundle:Ufr")->find($item[3]))
                                   ->setSection($em->getRepository("GOMainBundle:Section")->find($item[4]))
                                    ->setDate(new \DateTime())
                                    ->setActive(true)
                                    ->setDisabled(false);

                            $em->persist($Client);

                           
                    }else
                    {
                        if($oldClient->getPromo()==null)
                        {
                            $oldClient->setPromo($item[5]);
                            $em->persist($oldClient);
                        }
                    }
                     // flush everything to the database every 20 inserts
                            if (($i % $batchSize) == 0) {
                                $em->flush();
                                $em->clear();
                                // additionne 20 sur le batch size pour que la division egal 0 soit toujours possible
                                $batchSize = $batchSize+20;
                           }
                }

                // flush the remaining objects
                
                $em->clear();
                return new Response('Insertions Réussis');
}
}
