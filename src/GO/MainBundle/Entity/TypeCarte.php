<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeCarte
 *
 * @ORM\Table(name="type_carte", uniqueConstraints={@ORM\UniqueConstraint(name="libelle", columns={"libelle"})})
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\TypeCarteRepository")
 */
class TypeCarte
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_voyage", type="integer")
     */
    private $numVoyage;
    /**
     * @var integer
     *
     * @ORM\Column(name="tauxRemise", type="integer")
     */
    private $tauxRemise;

    /**
     * @var string
     *
     * @ORM\Column(name="services", type="string", length=255)
     */
    private $services;


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
     * @return TypeCarte
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
     * Set tauxRemise
     *
     * @param integer $tauxRemise
     * @return TypeCarte
     */
    public function setTauxRemise($tauxRemise)
    {
        $this->tauxRemise = $tauxRemise;

        return $this;
    }

    /**
     * Get tauxRemise
     *
     * @return integer 
     */
    public function getTauxRemise()
    {
        return $this->tauxRemise;
    }

    /**
     * Set services
     *
     * @param string $services
     * @return TypeCarte
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return string 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set numVoyage
     *
     * @param integer $numVoyage
     * @return TypeCarte
     */
    public function setNumVoyage($numVoyage)
    {
        $this->numVoyage = $numVoyage;

        return $this;
    }

    /**
     * Get numVoyage
     *
     * @return integer 
     */
    public function getNumVoyage()
    {
        return $this->numVoyage;
    }
}
