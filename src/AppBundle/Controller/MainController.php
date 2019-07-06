<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pays;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 *Main controller.
 * @Route("consulting/")
 */
class MainController extends Controller
{
    /**
     * Lists all pay entities.
     *
     * @Route("/", name="cons_homepage")
     
     */
    public function homepageAction()
    {
        return $this->render('@App/base_template.html.twig');
    }
    /**
     * switch boolean value
     *
     * @Route("switch_boolean/{entity}/{id}/{property}/{value}", name="boolean_switcher")
     
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
