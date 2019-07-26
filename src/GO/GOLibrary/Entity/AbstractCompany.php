<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\GOLibrary\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AbstractCompany
 *
 * @author LBC
 * @ORM/MappedSuperclass()
 */
class AbstractCompany {
    //put your code here
    /**
     * @var string
     * @ORM\Column(name="nom", type="string", unique=true)
     * 
     */
    protected $nom;
    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", nullable=true)
     * 
     */
    protected $adresse;
    /**
     * @var string
     * @ORM\Column(name="gerant", type="string")
     * 
     */
    protected $gerant;
    /**
     * @var string
     * @ORM\Column(name="tel", type="bigint", unique=true)
     * 
     */
    protected $tel;
    /**
     * @var string
     * @ORM\Column(name="email", type="string", unique=true, nullable=true)
     * 
     */
    protected $email;
    
}
