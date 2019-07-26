<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shop
 *
 * @ORM\Table(name="shop")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\ShopRepository")
 */
class Shop
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
     * @ORM\Column(name="libelle", type="string", length=100)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="gerant", type="integer")
     */
    private $gerant;

    /**
     * @var string
     *
     * @ORM\Column(name="horaire", type="string", length=255)
     */
    private $horaire;
    /**
     * @var string
     *
     * @ORM\Column(name="rccm", type="string", length=100)
     */
    private $rccm;
	/**
     * @var string
     *
     * @ORM\Column(name="ninea", type="string", length=100)
     */
    private $ninea;
	/**
         *
         * @var boolean
         * @ORM\Column(type="boolean")
         */
    private $ferme=false;
    /**
     * @var datetime
     * @ORM\Column(name="ferme_at", type="date", nullable=true)
     */
    private $fermeAt;
    
    /**
     * @var GO\ShopBundle\Entity\Company 
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Company", inversedBy="shops")
     * @ORM\JoinColumn(name="company", referencedColumnName="id", onDelete="cascade")
     */
    private $company;
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
     * Set libelle
     *
     * @param string $libelle
     * @return Shop
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Shop
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
     * @param integer $gerant
     * @return Shop
     */
    public function setGerant($gerant)
    {
        $this->gerant = $gerant;

        return $this;
    }

    /**
     * Get gerant
     *
     * @return integer 
     */
    public function getGerant()
    {
        return $this->gerant;
    }

    /**
     * Set horaire
     *
     * @param string $horaire
     * @return Shop
     */
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get horaire
     *
     * @return string 
     */
    public function getHoraire()
    {
        return $this->horaire;
    }

    /**
     * Set rccm
     *
     * @param string $rccm
     * @return Shop
     */
    public function setRccm($rccm)
    {
        $this->rccm = $rccm;

        return $this;
    }

    /**
     * Get rccm
     *
     * @return string 
     */
    public function getRccm()
    {
        return $this->rccm;
    }

    /**
     * Set ninea
     *
     * @param string $ninea
     * @return Shop
     */
    public function setNinea($ninea)
    {
        $this->ninea = $ninea;

        return $this;
    }

    /**
     * Get ninea
     *
     * @return string 
     */
    public function getNinea()
    {
        return $this->ninea;
    }
    public function __toString() {
        return $this->libelle;
    }

    /**
     * Set ferme
     *
     * @param boolean $ferme
     *
     * @return Shop
     */
    public function setFerme($ferme)
    {
        $this->ferme = $ferme;

        return $this;
    }

    /**
     * Get ferme
     *
     * @return boolean
     */
    public function getFerme()
    {
        return $this->ferme;
    }

    /**
     * Set fermeAt
     *
     * @param \DateTime $fermeAt
     *
     * @return Shop
     */
    public function setFermeAt($fermeAt)
    {
        $this->fermeAt = $fermeAt;

        return $this;
    }

    /**
     * Get fermeAt
     *
     * @return \DateTime
     */
    public function getFermeAt()
    {
        return $this->fermeAt;
    }

    /**
     * Set company
     *
     * @param \GO\ShopBundle\Entity\Company $company
     *
     * @return Shop
     */
    public function setCompany(\GO\ShopBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \GO\ShopBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
