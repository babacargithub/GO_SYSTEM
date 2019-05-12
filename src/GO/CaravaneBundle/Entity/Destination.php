<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Destination
 *
 * @ORM\Table(name="destination", indexes={@ORM\Index(name="trajet_des", columns={"trajet"})})
 * @ORM\Entity
 */
class Destination
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=55, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="tarif", type="integer", nullable=false)
     */
    private $tarif;

    /**
     * @var integer
     *
     * @ORM\Column(name="trajet", type="integer", nullable=false)
     */
    private $trajet;

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
     * @return Destination
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
     * @return Destination
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
     * Set trajet
     *
     * @param boolean $trajet
     * @return Destination
     */
    public function setTrajet($trajet)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return boolean 
     */
    public function getTrajet()
    {
        return $this->trajet;
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
}
