<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Entity;
use GO\GOLibrary\Entity\AbstractCompany;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits as SoftDeleteTraits;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\Mapping\Annotation\Timestampable;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Timestampable\Traits as TimestampableTraits;
use Gedmo\Blameable\Traits as BlameableTraits;
use Gedmo\Mapping\Annotation\Loggable;
use JMS\Serializer\Annotation as JMSSerializer;
/**
 *@ORM\Table(name="company_shop")
 *@ORM\Entity(repositoryClass="GO\ShopBundle\Entity\CompanyRepository")
 *@SoftDeleteable(fieldName="deletedAt")
 
 */
class Company extends AbstractCompany{
    //put your code here
    use SoftDeleteTraits\SoftDeleteableEntity;
    use TimestampableTraits\TimestampableEntity;
    use BlameableTraits\BlameableEntity;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMSSerializer\Groups({"list", "show"})
     */
    private $id;
    

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Company
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Company
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set gerant
     *
     * @param string $gerant
     *
     * @return Company
     */
    public function setGerant($gerant)
    {
        $this->gerant = $gerant;

        return $this;
    }

    /**
     * Get gerant
     *
     * @return string
     */
    public function getGerant()
    {
        return $this->gerant;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return Company
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
