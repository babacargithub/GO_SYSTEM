<?php
namespace GO\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ShopBundle\Form\CompanyType;
use GO\ShopBundle\Entity\Company;
use JMS\Serializer\SerializationContext;

/**
 * Description of DetteController
 *
 * @author hp
 */
class CompanyController extends MainController {
    /**
     * @Route("company/", name="company_get_all")
     */
    public function getAllAction()
    {
        $serializer= $this->get("jms_serializer");
        $companies= $this->getRepo('Company')->findAll();
        $companies=$serializer->serialize($companies,'json');
        return $this->render("@GOShop/Company/liste.html.twig",["companies"=>$companies]);
    }
    /**
     * @Route("company/{id}", name="company_show")
     */
    public function showAction(Request $req, Company $company)
    {
        $serializer= $this->get("jms_serializer");
        $company=$serializer->serialize($company,'json');
        return $this->render("@GOShop/Company/show.html.twig",["company"=>$company]);
    }
    /**
     * @Route("company/new", name="company_new")
     */
    public function newAction(Request $req)
    {
        $company=new Company();
        $form= $this->createForm(CompanyType::class,$company);
        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid())
        {
            $this->save($company);
            dump('success'); die();
        }
        return $this->render("@GOShop/Company/new.html.twig",["form"=>$form->createView()]);
    }
    /**
     * @Route("company/{id}/update", name="company_update")
     */
    public function editAction(Request $req, Company $company)
    {
        
        $form= $this->createForm(CompanyType::class,$company,["action"=> $this->generateUrl("company_update",["id"=>$company->getId()])]);
        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid())
        {
            $this->save($company);
            dump('success'); die();
        }
        return $this->render("@GOShop/Company/edit.html.twig",["form"=>$form]);
    }
}