<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compte
 *
 * @ORM\Table(name="compte")
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\CompteRepository")
 */
class Compte
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
     * @ORM\Column(name="libelle", type="string", length=160)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCree", type="date")
     */
    private $dateCree;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="numCompte", type="integer")
     */
    private $numCompte;


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
     * @return Compte
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
     * Set dateCree
     *
     * @param \DateTime $dateCree
     * @return Compte
     */
    public function setDateCree($dateCree)
    {
        $this->dateCree = $dateCree;

        return $this;
    }

    /**
     * Get dateCree
     *
     * @return \DateTime 
     */
    public function getDateCree()
    {
        return $this->dateCree;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Compte
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
     * Set numCompte
     *
     * @param integer $numCompte
     * @return Compte
     */
    public function setNumCompte($numCompte)
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    /**
     * Get numCompte
     *
     * @return integer 
     */
    public function getNumCompte()
    {
        return $this->numCompte;
    }
}
