<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caissier
 *
 * @ORM\Table(name="caissier")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\CaissierRepository")
 */
class Caissier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="bigint", unique=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="shortName", type="string", length=6, nullable=true, unique=true)
     */
    private $shortName;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleated", type="boolean", nullable=true)
     */
    private $deleated=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleated_at", type="datetime", nullable=true)
     */
    private $deleatedAt;
/**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_account", referencedColumnName="id", nullable=false)
     * })
     */
    private $userAccount;


    /**
     * Set userAccount
     *
     * @param \GO\UserBundle\Entity\User $user
     * @return BaseClass
     */
    public function setUserAccount(\GO\UserBundle\Entity\User $user)
    {
        $this->userAccount = $user;

        return $this;
    }

    /**
     * Get userAccount
     *
     * @return \GO\UserBundle\Entity\User 
     */
    public function getUserAccount()
    {
        return $this->userAccount;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Caissier
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Caissier
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
     * Set tel
     *
     * @param integer $tel
     *
     * @return Caissier
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Caissier
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
     * Set shortName
     *
     * @param string $shortName
     *
     * @return Caissier
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return Caissier
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return bool
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Caissier
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set deleated
     *
     * @param boolean $deleated
     *
     * @return Caissier
     */
    public function setDeleated($deleated)
    {
        $this->deleated = $deleated;

        return $this;
    }

    /**
     * Get deleated
     *
     * @return bool
     */
    public function getDeleated()
    {
        return $this->deleated;
    }

    /**
     * Set deleatedAt
     *
     * @param \DateTime $deleatedAt
     *
     * @return Caissier
     */
    public function setDeleatedAt($deleatedAt)
    {
        $this->deleatedAt = $deleatedAt;

        return $this;
    }

    /**
     * Get deleatedAt
     *
     * @return \DateTime
     */
    public function getDeleatedAt()
    {
        return $this->deleatedAt;
    }
    
    public function __toString() {
        return ucfirst($this->prenom).' '.strtoupper($this->nom);
    }
}

