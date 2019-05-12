<?php

namespace GO\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GOEmployeeBundle:Default:index.html.twig');
    }
}
