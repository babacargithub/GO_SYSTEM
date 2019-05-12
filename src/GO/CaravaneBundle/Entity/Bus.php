<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bus
 *
 * @ORM\Table(name="bus")
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\BusRepository")
 */
class Bus
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
     * @ORM\Column(name="matricule", type="string", length=20, nullable=true)
     */
    private $matricule;

    /**
     * @var \GO\CaravaneBundle\Entity\Chauffeur
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Chauffeur", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chauffeur", referencedColumnName="id", nullable=true)
     * })
     */
    private $chauffeur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombrePlace", type="integer")
     */
    private $nombrePlace;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="observations", type="string", length=255)
     */
    private $observations;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;


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
     * Set matricule
     *
     * @param string $matricule
     * @return Bus
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string 
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set chauffeur
     *
     * @param integer $chauffeur
     * @return Bus
     */
    public function setChauffeur($chauffeur)
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    /**
     * Get chauffeur
     *
     * @return integer 
     */
    public function getChauffeur()
    {
        return $this->chauffeur;
    }

    /**
     * Set nombrePlace
     *
     * @param integer $nombrePlace
     * @return Bus
     */
    public function setNombrePlace($nombrePlace)
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    /**
     * Get nombrePlace
     *
     * @return integer 
     */
    public function getNombrePlace()
    {
        return $this->nombrePlace;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Bus
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Bus
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set observations
     *
     * @param string $observations
     * @return Bus
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string 
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Bus
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
}
