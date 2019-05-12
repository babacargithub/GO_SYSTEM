<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fournisseur
 *
 * @ORM\Table(name="fournisseur", uniqueConstraints={@ORM\UniqueConstraint(name="tel", columns={"tel"})})
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\FournisseurRepository")
 */
class Fournisseur
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer", nullable=false)
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
     * @ORM\Column(name="gerant", type="string", length=255, nullable=true)
     */
    private $gerants;
    /**
     * @var integer
     *
     * @ORM\Column(name="ville", type="integer", nullable=true)
     */
    
    private $ville;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;




    /**
     * Set nom
     *
     * @param string $nom
     * @return Fournisseur
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
     * @return Fournisseur
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
     * @return Fournisseur
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
     * Set ville
     *
     * @param integer $ville
     * @return Fournisseur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return integer 
     */
    public function getVille()
    {
        return $this->ville;
    }

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
     * Set gerants
     *
     * @param string $gerants
     * @return Fournisseur
     */
    public function setGerants($gerants)
    {
        $this->gerants = $gerants;

        return $this;
    }

    /**
     * Get gerants
     *
     * @return string 
     */
    public function getGerants()
    {
        return $this->gerants;
    }
    public function __toString() {
        return $this->nom;
    }
}
