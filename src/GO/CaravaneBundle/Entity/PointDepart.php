<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointDepart
 *
 * @ORM\Table(name="point_depart", indexes={@ORM\Index(name="nom_point_dep", columns={"nom"}), @ORM\Index(name="lieu", columns={"trajet"})})
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\PointDepartRepository")
 */
class PointDepart
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trajet", type="integer", nullable=true)
     */
    private $trajet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_point_dep", type="time", nullable=true)
     */
    private $heurePointDep;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_point_dep_soir", type="time", nullable=true)
     */
    private $heurePointDepSoir;

    /**
     * @var string
     *
     * @ORM\Column(name="arret_bus", type="string", length=256, nullable=true)
     */
    private $arretBus;

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
     * @return PointDepart
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
     * Set trajet
     *
     * @param boolean $trajet
     * @return PointDepart
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
     * Set heurePointDep
     *
     * @param \DateTime $heurePointDep
     * @return PointDepart
     */
    public function setHeurePointDep($heurePointDep)
    {
        $this->heurePointDep = $heurePointDep;

        return $this;
    }

    /**
     * Get heurePointDep
     *
     * @return \DateTime 
     */
    public function getHeurePointDep()
    {
        return $this->heurePointDep;
    }

    /**
     * Set heurePointDepSoir
     *
     * @param \DateTime $heurePointDepSoir
     * @return PointDepart
     */
    public function setHeurePointDepSoir($heurePointDepSoir)
    {
        $this->heurePointDepSoir = $heurePointDepSoir;

        return $this;
    }

    /**
     * Get heurePointDepSoir
     *
     * @return \DateTime 
     */
    public function getHeurePointDepSoir()
    {
        return $this->heurePointDepSoir;
    }

    /**
     * Set arretBus
     *
     * @param string $arretBus
     * @return PointDepart
     */
    public function setArretBus($arretBus)
    {
        $this->arretBus = $arretBus;

        return $this;
    }

    /**
     * Get arretBus
     *
     * @return string 
     */
    public function getArretBus()
    {
        return $this->arretBus;
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
    public function __toString() {
        return $this->nom;
    }
}
