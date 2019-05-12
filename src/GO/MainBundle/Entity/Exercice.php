<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercice
 *
 * @ORM\Table(name="exercice", indexes={@ORM\Index(name="date_debut_exercice", columns={"date_debut_exercice", "date_fin_exercice"})})
 * @ORM\Entity
 */
class Exercice
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle_exercice", type="string", length=100, nullable=false)
     */
    private $libelleExercice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_exercice", type="date", nullable=false)
     */
    private $dateDebutExercice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_exercice", type="date", nullable=false)
     */
    private $dateFinExercice;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_exercice", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idExercice;



    /**
     * Set libelleExercice
     *
     * @param string $libelleExercice
     * @return Exercice
     */
    public function setLibelleExercice($libelleExercice)
    {
        $this->libelleExercice = $libelleExercice;

        return $this;
    }

    /**
     * Get libelleExercice
     *
     * @return string 
     */
    public function getLibelleExercice()
    {
        return $this->libelleExercice;
    }

    /**
     * Set dateDebutExercice
     *
     * @param \DateTime $dateDebutExercice
     * @return Exercice
     */
    public function setDateDebutExercice($dateDebutExercice)
    {
        $this->dateDebutExercice = $dateDebutExercice;

        return $this;
    }

    /**
     * Get dateDebutExercice
     *
     * @return \DateTime 
     */
    public function getDateDebutExercice()
    {
        return $this->dateDebutExercice;
    }

    /**
     * Set dateFinExercice
     *
     * @param \DateTime $dateFinExercice
     * @return Exercice
     */
    public function setDateFinExercice($dateFinExercice)
    {
        $this->dateFinExercice = $dateFinExercice;

        return $this;
    }

    /**
     * Get dateFinExercice
     *
     * @return \DateTime 
     */
    public function getDateFinExercice()
    {
        return $this->dateFinExercice;
    }

    /**
     * Get idExercice
     *
     * @return integer 
     */
    public function getIdExercice()
    {
        return $this->idExercice;
    }
}
