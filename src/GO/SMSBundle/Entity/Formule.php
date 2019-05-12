<?php

namespace  GO\SMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formule
 *
 * @ORM\Table(name="formule", uniqueConstraints={@ORM\UniqueConstraint(name="libelle_abnmnt", columns={"libelle"})}, indexes={@ORM\Index(name="prix_abnmnt", columns={"tarif"}), @ORM\Index(name="abrv", columns={"abrv"})})
 * @ORM\Entity(repositoryClass="GO\SMSBundle\Entity\FormuleRepository")
 */
class Formule
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=100, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="tarif", type="integer", nullable=false)
     */
    private $tarif;

    /**
     * @var string
     *
     * @ORM\Column(name="abrv", type="string", length=20, nullable=true)
     */
    private $abrv;
    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;
    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif=true;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Formule
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
     * Set tarif
     *
     * @param integer $tarif
     * @return Formule
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return integer 
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set abrv
     *
     * @param string $abrv
     * @return Formule
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
     * Set duree
     *
     * @param integer $duree
     * @return Formule
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Formule
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
    //============fonctions diverses======================
    public function getTarifMois()
    {
        $montant=$this->tarif/$this->duree;
        return $montant;
    }
}
