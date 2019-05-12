<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ClientBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Table(name="crm_categorie_client")
 * @ORM\Entity()
 * @UniqueEntity(fields={"name"}, message="Catégorie client existe déjà!")
 **/
class CategorieClient {
    //put your code here
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    * */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false, unique=true)
     * @Assert\Length(min=2, minMessage="Le nom doit de la catégorie doit contenir au moins deux caractères")
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="abrv", type="string", nullable=false, unique=true, length=5)
     * @Assert\Length(min=5, max=5, minMessage="Abréviation catégorie trop courte",minMessage="Abréviation catégorie trop longue")
     */
    private $abrv;
     /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     
     */
    private $comments;
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TypeCompte
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return TypeCompte
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set abrv
     *
     * @param string $abrv
     *
     * @return CategorieClient
     */
    public function setAbrv($abrv)
    {
        $this->abrv = $abrv;

        return $this;
    }

    /**
     * Get abrv
     *
     * @return string
     */
    public function getAbrv()
    {
        return $this->abrv;
    }
    //=========
    //=========
    public function __toString() {
        return $this->name;
    }
}
