<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class GOAccessDeniedHandler implements AccessDeniedHandlerInterface {
    //put your code here
    public function handle(Request $request, AccessDeniedException $accessDeniedException) {
        return new Response("Vous n'êts pas autorisé à accéder à cette adresse de l'application");
    }

}
