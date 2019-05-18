<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ClientBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FosRest;
use GO\ClientBundle\Entity\Client;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;
use GO\ClientBundle\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of ApiController
 *
 * @author LBC
 */
class TestController extends \GO\MainBundle\Controller\BaseController {
 
    /**
     * 
     * @param Request $req
     * @Route("/test/form_handler", name="test_form_hander")
     */
    public function testFormHandler(Request $req)
    {
        $form= $this->createForm(ClientType::class, new Client(), ["action"=> $this->generateUrl("test_form_hander_response")]);
        $form->get('email')->setData("hdjdcom@hhf.fr");
        $form->get('prenom')->setData("hdjdcom");
        $form->get('nom')->setData("hdjd");
        $form->get('tel')->setData(773300849);
        $form->get('sexe')->setData("F");
        $form->handleRequest($req);
       
        return $this->render("@GOClient/client/new_test.html.twig",['form'=>$form->createView()]);
        
    }
    /**
     * 
     * @param Request $req
     * @Route("/test/form_handler_response", name="test_form_hander_response")
     */
    public function testFormHandlerResponse(Request $req)
    {
        $client=new Client();
        $client->setPrenom("123DH")->setEmail("dhhdh")->setTel(773300853);
        $form= $this->createForm(ClientType::class, $client);
        $form->handleRequest($req);
        //$form->get('tel')->addError(new \Symfony\Component\Form\FormError("Telephone du client invalide!"));
        if($form->isSubmitted()&&$form->isValid())
        {
          $response=new Response("Valide form");
        $response->headers->set('Content-Type','application/json');
        return $response;   
        }
        
        /*$response->setContent('{
    "code": 400,
    "message": "Validation Failed",
    "errors": {
        "errors": [
            "Le jeton CSRF est invalide. Veuillez renvoyer le formulaire.",
            "Cette valeur ne doit pas être vide.",
            "Cette valeur ne doit pas être vide."
        ],
        "children": {
            "firstName": {},
            "lastName": {},
            "tel": {
                "errors": [
                    "Ce numéro téléphone est déjà utilisé par un autre client!",
                    "Telephone du client invalide!"
                ]
            },
            "email": {
                "errors": [
                    "Cette valeur n\'est pas une adresse email valide."
                ]
            },
            "adresse": {},
            "sexe": {},
            "categorie": {
                "errors": [
                    "Cette valeur n\'est pas valide."
                ]
            }
        }
    }
}');*/
        return $this->render("@GOClient/client/new_test.html.twig",['form'=>$form]);
        
    }
}
