<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ApiBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use GO\CaravaneBundle\Form\ReservationType;
use GO\CaravaneBundle\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     * @Rest\View(statusCode=201)
     * 
     */
    public function reservationNewAction(Request $req)
    {
        //$reservation=new Reservation();
        $reservation=new \GO\ClientBundle\Entity\Client();
        $form= $this->createForm(\GO\ClientBundle\Form\ClientType::class, $reservation);
        $data = $this->get('jms_serializer')->deserialize($req->getContent(), 'array', 'json');
        $form->submit($data);
        //$reservation->setDate(new \DateTime())->setAgent($this->getDoctrine()->getRepository("GOUserBundle:User")->find(3))->setConfirme(true);
        //$em= $this->getDoctrine()->getManager();
        $violations= $this->get("validator")->validate($reservation);
        if(count($violations)>0)
        {
            return $violations;
        }
       // $em->persist($reservation);
        //$em->flush();
        return "Réservation enregistré";
    }
    public function reservationUpdateAction()
    {
        
    }
    public function reservationCancelAction()
    {
        
    }
    /**
     * @Rest\Get("departs/", name="api_get_departs")
     * @Rest\View
     */
    public function departGetListAction()
    {
        $departs= $this->getRepo('Depart')->getListeDeparts(\GO\CaravaneBundle\Utils\Constants::DEPART_NON_PASSE);
  return $departs;
        
    }
    public function pointDepartGetListAction()
    {
        
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
