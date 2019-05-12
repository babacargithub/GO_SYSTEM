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
/**
 * Description of ApiController
 *
 * @author LBC
 */
class ApiController extends FOSRestController {
    //put your code here
    /**
     * @FosRest\Post(
     path="/api/client/create",
      name="api_new_client")
     *@ParamConverter("client", converter="fos_rest.request_body")
     * @View()
     */
    public function createClient(Client $client)
    {
        var_dump($client);die();
        $this->view();
    }
    /**
     * 
     * @param Client $client
     * @Route("api2/client/create")
     */
    public function createClientBis(Client $client)
    {
        var_dump($client);die();
        $this->view();
    }
}
