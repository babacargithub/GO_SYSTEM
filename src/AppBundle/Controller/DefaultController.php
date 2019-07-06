<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    
        /**
     * switch boolean value
     *
     * @Route("/switch_boolean/{entity}/{id}/{property}/{value}", name="boolean_switcher2")
     
     */
    public function booleanSwitcher(Request $req)
    {
        $Entity=ucfirst($req->get('entity'));
        $object= $this->getDoctrine()->getRepository("AppBundle:$Entity")->find($req->get('id'));
        $property=$req->get('property');
        $set="set".ucfirst($property);
        $booleanValue=!$req->get('value');
        $object->$set($booleanValue);
        $em=$this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
                
        
    }
}
