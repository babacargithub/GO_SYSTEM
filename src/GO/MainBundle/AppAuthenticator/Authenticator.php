<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\AppAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\SecurityContext;
use GO\UserBundle\Entity\User;
/**
 * Description of Authenticator
 *
 * @author hp
 */
class Authenticator extends Controller{
    //put your code here
    private $security_context;
    public function __construct(SecurityContext $security_context) {
        $this->security_context = $security_context;
        
    }

    public function authenticate(Request $req)
    {
        
        if(preg_match("#online_pay_callback.golob$#",$req->getUri())
                ||preg_match("#login$#",$req->getUri())
                ||preg_match("#login_check$#",$req->getUri())
                ||preg_match("#select_app$#",$req->getUri())
                ||preg_match("#authenticate_app$#",$req->getUri())
                ||preg_match("#online_payer-[0-9]{1,}.golob$#",$req->getUri())
                )
        {
            
        }else
        {
            if($req->getSession()->has('connected_app'))
            {
                
            } else {
                
               // return $this->redirectToRoute("select_app");
                //header('location: main/select_app');exit();   
            }
               
        }
    }
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->authenticate($event->getRequest());
    }
    public function authenticateApp(User $user,$role)
    {
        if($this->security_context->isGranted($role))
            return true;
        else
            return false;
        
    }
}
