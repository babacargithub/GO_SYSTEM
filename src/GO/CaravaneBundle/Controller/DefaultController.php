<?php

namespace GO\CaravaneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GOCaravaneBundle:Default:index.html.twig', array('name' => $name));
    }
}
