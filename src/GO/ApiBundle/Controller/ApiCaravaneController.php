<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ApiBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GO\CaravaneBundle\Form\ReservationType;
use GO\CaravaneBundle\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\Serializer\SerializationContext;


/**
 * Description of ApiController
 *
 * @author LBC
 */
class ApiCaravaneController extends \GO\CaravaneBundle\Controller\MainController{
    //put your code here
    /**
     * 
     * @param Request $req
     * @Rest\Post("/reservation/new", name="api_reservation_new")
     * @Rest\View()
     * 
     */
    public function reservationNewAction(Request $req)
    {
        $reservation=new Reservation();
        //$reservation=new \GO\ClientBundle\Entity\Client();
        $form= $this->createForm(ReservationType::class, $reservation,array('csrf_protection' => false));
        $serializer = $this->get('jms_serializer');
        $data = $serializer->deserialize($req->getContent(), 'array', 'json');
        
        $form->submit($data);
        $agent=$this->getDoctrine()->getRepository("GOUserBundle:User")->find(3);
        $reservation->setDate(new \DateTime())
                ->setAgent($agent)->setConfirme(true);
        $em= $this->getDoctrine()->getManager();
       $response=new Response();
        $response->headers->set("Content-Type","application/json");
        if($form->isSubmitted()&&$form->isValid())
        {
        $violations= $this->get("validator")->validate($reservation);
        if(count($violations)>0)
        {
            return $violations;
        } 
       
        $em->persist($reservation);
       if(isset($data['paye']))
       {
            if(($data['paye']))
            {
                $paye=new \GO\CaravaneBundle\Entity\Payer;
                $paye->setRes($reservation)
                        ->setMontant($reservation->getDes()->getTarif())
                        ->setAgent($agent)
                        ->setDate(new \DateTime())
                        ->setCodeRecu(3119299);
                $em->persist($paye);
                $reservation->setPaye(true);
                $reservation->setNumPlace($this->get('go_caravane.seat_number_generator')->generateSeat($reservation)->getNumPlace());
                $em->persist($reservation);
            }
       }
       
       $em->flush();
        $params=["message"=>"Réservation enregistrée avec succès!","code"=>201,"type"=>"success"];
        $response->setContent($serializer->serialize($params,"json")); 
         return $response;
        }
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
       
           $params=["message"=>"Une erreur s'est produite, données envoyées invalides! ","code"=>400,"type"=>"error"];
        $response->setContent($serializer->serialize($params,"json")); 
         return $response;
    }
    public function reservationUpdateAction()
    {
        
    }
    public function reservationCancelAction()
    {
        
    }
    /**
     * @Rest\Get("departs/", name="api_get_departs")
     * @Rest\View( serializerGroups = {"list_for_api"})
     */
    public function departGetListAction()
    {
        $departs= $this->getRepo('Depart')->getListeDeparts(\GO\CaravaneBundle\Utils\Constants::DEPART_NON_PASSE)->getQuery()->getResult();
        $serializer=$this->get("jms_serializer");
       $departs= $serializer->serialize($departs,"json", SerializationContext::create()->setGroups(["list_for_api"]));
        $response= new Response();
        $response->headers->set("Content-Type","application/json");
        $response->setContent($departs);
        return $response;
        
    }
    /**
     * 
     * @return JsonResponse
     * @Rest\Get("point_departs/", name="api_point_departs")
     * @Rest\Get("point_departs/{trajet}", name="api_point_departs_with_filter")
     * @Rest\View()
     */
    public function pointDepartGetListAction(Request $req)
    {
        
         $pointDeparts= $this->getRepo('PointDepart')->findAll();
         $trajet=$req->get('trajet');
         if($trajet!=null)
         {
         $pointDeparts= $this->getRepo('PointDepart')->findByTrajet($trajet);
         }
        $serializer=$this->get("jms_serializer");
        $pointDeparts= $serializer->serialize($pointDeparts,"json",SerializationContext::create()->setGroups(["list_for_api"]));
        $response= new JsonResponse();
        //$response->headers->set("Content-Type","application/json");
        $response->setContent($pointDeparts);
        return $response;
    }
    /**
     * 
     * @return JsonResponse
     * @Rest\Get("destinations/", name="api_destinations")
     * @Rest\Get("destinations/{trajet}", name="api_destinations_with_filter")
     * @Rest\View()
     */
    public function destinationGetListAction(Request $req)
    {
        
         $pointDeparts= $this->getRepo('Destination')->findAll();
         $trajet=$req->get('trajet');
         if($trajet!=null)
         {
         $pointDeparts= $this->getRepo('Destination')->findByTrajet($trajet);
         }
        $serializer=$this->get("jms_serializer");
        $pointDeparts= $serializer->serialize($pointDeparts,"json");
        $response= new JsonResponse();
        //$response->headers->set("Content-Type","application/json");
        $response->setContent($pointDeparts);
        return $response; 
    }
    /**
     * @return JsonResponse 
     * @Rest\Get("etats_departs/", name="api_etats_departs")
     * @Rest\View( serializerGroups = {"list_for_api"})
     */
    public function etatsDepartAction(Request $req)
    {
        $response= $this->forward("GOCaravaneBundle:Depart:etatDeparts",['req'=>$req]);
        //$view= $this->view();
        return $response;
    }
    public function clientDetailsAction()
    {
        
    }
    public function clientHistoryAction()
    {
        
    }
    public function clientSubscribeSMSAction()
    {
        
    }
}
