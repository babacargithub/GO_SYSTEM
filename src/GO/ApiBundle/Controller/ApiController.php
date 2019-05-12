<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace GO\ApiBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\Route;
use GO\CaravaneBundle\Utils\Constants as Cons;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use GO\CaravaneBundle\Entity\Depart;
use GO\CaravaneBundle\Entity\Reservation;
use GO\CaravaneBundle\Form\ReservationType;
use Symfony\Component\Validator\ConstraintViolationList;
class ApiController extends FOSRestController
{
    /**
     * @Route("/api")
     */
    public function indexAction()
    {
        $data = array("hello" => "world");
        $view = $this->view($data);
        $view->setTemplate("base.html.twig");
        return $this->handleView($view);
    }
    /**
     * @FOSRest\Get("/api/departs")
     * @FOSRest\View()
     */
    public function listeDepartsAction()
    {
        $data = $this->getDoctrine()->getRepository('GOCaravaneBundle:Depart')
                ->getListeDeparts(Cons::DEPART_TROIS_JR)->orderBy('d.date','DESC')->getQuery()->getResult();
      
        $view = $this->view($this->getUser());
        $view->setTemplate("@GOCaravane/Depart/show.html.twig");
        $view->setTemplateVar("departs")
                ->setTemplateData(["liste"=>$data]);
        return $this->handleView($view);
    }
    /**
     * @FOSRest\Post("/api/departs")
     * @FOSRest\View()
     * @ParamConverter("reservation", converter="fos_rest.request_body")
     */
    public function newReservationAction(Reservation $reservation, ConstraintViolationList $violations)
    {
      if(count($violations))
      {
          return $this->view($violations, Response::HTTP_BAD_REQUEST);
      }
       $em= $this->getDoctrine()->getManager();
       $em->persist($reservation);
       $em->persist($reservation);
       //$em->flush();
        $view = $this->view($reservation->getClient());
        //$view->setTemplate("@GOCaravane/Depart/show.html.twig");
        /*$view->setTemplateVar("departs")
                ->setTemplateData(["liste"=>$data]);*/
        return $this->handleView($view);
    }
}