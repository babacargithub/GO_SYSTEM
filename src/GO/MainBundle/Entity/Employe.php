<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employe
 *
 * @ORM\Table(name="employe")
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\EmployeRepository")
 */
class Employe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=150)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="poste", type="integer",nullable=true)
     */
    private $poste;

    /**
     * @var integer
     *
     * @ORM\Column(name="salaire", type="integer",nullable=true)
     */
    private $salaire;
    
    private $numeroCompte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEmbauche", type="date")
     */
    private $dateEmbauche;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer")
     */
    private $statut;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="suspendu", type="boolean",nullable=true)
     */
    private $suspendu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var integer
     *
     * @ORM\Column(name="cni", type="bigint",nullable=true)
     */
    private $cni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDelivCni", type="date",nullable=true)
     */
    private $dateDelivCni;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dateExpCni", type="date",nullable=true)
     */
    private $dateExpCni;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="cvUrl", type="string", length=255)
     */
    private $cvUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="photoProfilUrl", type="string", length=255)
     */
    private $photoProfilUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="typeContrat", type="integer")
     */
    private $typeContrat;


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
     * Set prenom
     *
     * @param string $prenom
     * @return Employe
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
     * @return Employe
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
     * @return Employe
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
     * @return Employe
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

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Employe
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
     * Set poste
     *
     * @param integer $poste
     * @return Employe
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return integer 
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set salaire
     *
     * @param integer $salaire
     * @return Employe
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return integer 
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
     * @return Employe
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * Get dateEmbauche
     *
     * @return \DateTime 
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Employe
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Employe
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set suspendu
     *
     * @param boolean $suspendu
     * @return Employe
     */
    public function setSuspendu($suspendu)
    {
        $this->suspendu = $suspendu;

        return $this;
    }

    /**
     * Get suspendu
     *
     * @return boolean 
     */
    public function getSuspendu()
    {
        return $this->suspendu;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Employe
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set cni
     *
     * @param integer $cni
     * @return Employe
     */
    public function setCni($cni)
    {
        $this->cni = $cni;

        return $this;
    }

    /**
     * Get cni
     *
     * @return integer 
     */
    public function getCni()
    {
        return $this->cni;
    }

    /**
     * Set dateDelivCni
     *
     * @param \DateTime $dateDelivCni
     * @return Employe
     */
    public function setDateDelivCni($dateDelivCni)
    {
        $this->dateDelivCni = $dateDelivCni;

        return $this;
    }

    /**
     * Get dateDelivCni
     *
     * @return \DateTime 
     */
    public function getDateDelivCni()
    {
        return $this->dateDelivCni;
    }

    /**
     * Set dateExpCni
     *
     * @param boolean $dateExpCni
     * @return Employe
     */
    public function setDateExpCni($dateExpCni)
    {
        $this->dateExpCni = $dateExpCni;

        return $this;
    }

    /**
     * Get dateExpCni
     *
     * @return boolean 
     */
    public function getDateExpCni()
    {
        return $this->dateExpCni;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Employe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set cvUrl
     *
     * @param string $cvUrl
     * @return Employe
     */
    public function setCvUrl($cvUrl)
    {
        $this->cvUrl = $cvUrl;

        return $this;
    }

    /**
     * Get cvUrl
     *
     * @return string 
     */
    public function getCvUrl()
    {
        return $this->cvUrl;
    }

    /**
     * Set photoProfilUrl
     *
     * @param string $photoProfilUrl
     * @return Employe
     */
    public function setPhotoProfilUrl($photoProfilUrl)
    {
        $this->photoProfilUrl = $photoProfilUrl;

        return $this;
    }

    /**
     * Get photoProfilUrl
     *
     * @return string 
     */
    public function getPhotoProfilUrl()
    {
        return $this->photoProfilUrl;
    }

    /**
     * Set typeContrat
     *
     * @param integer $typeContrat
     * @return Employe
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    /**
     * Get typeContrat
     *
     * @return integer 
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }
    public function __toString() {
        return $this->prenom." ".$this->nom;
    }
}
