<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientRevendeur
 *
 * @ORM\Table(name="client_revendeur")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\ClientRevendeurRepository")
 */
class ClientRevendeur
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
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer")
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
     * @ORM\Column(name="societe", type="string", length=255, nullable=true)
     */
    private $societe;
    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=100, nullable=true)
     */
    private $statut;
    /**
     * @var string
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;


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
     * @return ClientRevendeur
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
        return ucwords($this->prenom);
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return ClientRevendeur
     */
    public function setNom($nom)
    {
        $this->nom =$nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return strtoupper($this->nom);
        
    }

    /**
     * Set tel
     *
     * @param integer $tel
     * @return ClientRevendeur
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
     * Set adresse
     *
     * @param string $adresse
     * @return ClientRevendeur
     */
    public function setAdresse($adresse=null)
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
     * Set societe
     *
     * @param string $societe
     * @return ClientRevendeur
     */
    public function setSociete($societe=null)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return string 
     */
    public function getSociete()
    {
        return $this->societe;
    }
    public function __toString() {
        return $this->getPrenom()." ".$this->getNom();
    }
}
