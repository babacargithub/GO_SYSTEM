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
}
