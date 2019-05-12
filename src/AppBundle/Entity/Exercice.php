<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercice
 *
 * @ORM\Table(name="exercice_cons")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExerciceRepository")
 */
class Exercice
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="date")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="date")
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @var bool
     *
     * @ORM\Column(name="current", type="boolean", nullable=true)
     */
    private $current;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dossier", mappedBy="exercice", cascade={"persist"})
     */
    private $dossiers;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Exercice
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Exercice
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Exercice
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Exercice
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set current
     *
     * @param boolean $current
     *
     * @return Exercice
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return bool
     */
    public function getCurrent()
    {
        return $this->current;
    }
     public function __toString() {
        return $this->libelle;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dossiers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dossier
     *
     * @param \AppBundle\Entity\Dossier $dossier
     *
     * @return Exercice
     */
    public function addDossier(\AppBundle\Entity\Dossier $dossier)
    {
        $this->dossiers[] = $dossier;

        return $this;
    }

    /**
     * Remove dossier
     *
     * @param \AppBundle\Entity\Dossier $dossier
     */
    public function removeDossier(\AppBundle\Entity\Dossier $dossier)
    {
        $this->dossiers->removeElement($dossier);
    }

    /**
     * Get dossiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossiers()
    {
        return $this->dossiers;
    }
    
    //===============Extra functions for counting and statistiques 
    public function getNombreDossiers()
    {
        return count($this->dossiers);
    }
    
    public function getTotalPaiements()
    {
        $total=0;
        foreach($this->dossiers as $dossier)
        {
            $total=$total+$dossier->getTotalPaiements();
        }
        return intval($total);
    }
    public function getNombreDossiersParSexe($sexe)
    {
        
    }
    public function getNombreCandidaturesParReponse($reponse)
    {
        
    }
    public function getTotalCandidatures()
    {
        $total=0;
        foreach($this->dossiers as $dossier)
        {
            $total=$total+count($dossier->getCandidatures());
        }
        return intval($total);
        
    }
    
}
