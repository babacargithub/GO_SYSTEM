<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\GOLibrary\Doctrine\Filter;

/**
 * Description of Configurator
 *
 * @author LBC
 */
use Symfony\Component\Security\Core\User\UserInterface;  
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;  
use Doctrine\Common\Persistence\ObjectManager;  
use Doctrine\Common\Annotations\Reader;

class Configurator  
{
    protected $em;
    protected $tokenStorage;
    protected $reader;

    public function __construct(ObjectManager $em, TokenStorageInterface $tokenStorage, Reader $reader)
    {
        $this->em              = $em;
        $this->tokenStorage    = $tokenStorage;
        $this->reader          = $reader;
    }

    public function onKernelRequest()
    {
        if (null!= $this->getUser()) {
            $user= $this->getUser();
            $filter = $this->em->getFilters()->enable('user_filter');
            $filter->setParameter('user_id', $user->getId());
            $filter->setAnnotationReader($this->reader);
        }
    }

    private function getUser()
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return null;
        }

        $user = $token->getUser();

        if (!($user instanceof UserInterface)) {
            return null;
        }

        return $user;
    }
}