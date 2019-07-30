<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\GOLibrary\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use GO\MainBundle\Validator\Constraints\PhoneNumber;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMSSerializer;
/**
 * Description of AbstractCompany
 *
 * @author LBC
 * @ORM\MappedSuperclass()
 * @UniqueEntity(fields={"nom"},message="Cette société existe déjà")
 * @UniqueEntity(fields={"tel"},message="Ce téléphone est déjà utilisé")
 * @UniqueEntity(fields={"email"},message="Cet email est déjà utilisé")
 */
class AbstractCompany {
    
    //put your code here
    /**
     * @var string
     * @ORM\Column(name="nom", type="string", unique=true)
     * @Assert\NotBlank()
     * @JMSSerializer\Groups({"list", "show"})
     * 
     */
    protected $nom;
    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", nullable=true)
     * @Assert\NotBlank()
     * @JMSSerializer\Groups({"list", "show"})
     */
    protected $adresse;
    /**
     * @var string
     * @ORM\Column(name="gerant", type="string")
     * @Assert\NotBlank()
     * @JMSSerializer\Groups({"list", "show"})
     * 
     */
    protected $gerant;
    /**
     * @var string
     * @ORM\Column(name="tel", type="bigint", unique=true)
     * @PhoneNumber()
     * @JMSSerializer\Groups({"list", "show"})
     */
    protected $tel;
    /**
     * @var string
     * @ORM\Column(name="email", type="string", unique=true, nullable=true)
     * @Assert\Email()
     * @JMSSerializer\Groups({"list", "show"})
     */
    protected $email;
    
}
