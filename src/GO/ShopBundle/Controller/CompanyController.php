<?php
namespace GO\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of DetteController
 *
 * @author hp
 */
class CompanyController extends MainController {
    /**
     * @Route("company/", name="company_get_all")
     */
    public function getAll()
    {
        $companies= $this->getRepo('Company')->findAll();
        dump($companies);die();
    }
}