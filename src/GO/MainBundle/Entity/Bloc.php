<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bloc
 *
 * @ORM\Table(name="bloc", uniqueConstraints={@ORM\UniqueConstraint(name="nom_g", columns={"nom"})})
 * @ORM\Entity
 */
class Bloc
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=4, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="village", type="integer", nullable=true)
     */
    private $village;

    /**
     * @var integer
     *
     * @ORM\Column(name="gere_par", type="integer", nullable=true)
     */
    private $gerePar;

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
     * @return Bloc
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
     * Set village
     *
     * @param integer $village
     * @return Bloc
     */
    public function setVillage($village)
    {
        $this->village = $village;

        return $this;
    }

    /**
     * Get village
     *
     * @return integer 
     */
    public function getVillage()
    {
        return $this->village;
    }

    /**
     * Set gerePar
     *
     * @param integer $gerePar
     * @return Bloc
     */
    public function setGerePar($gerePar)
    {
        $this->gerePar = $gerePar;

        return $this;
    }

    /**
     * Get gerePar
     *
     * @return integer 
     */
    public function getGerePar()
    {
        return $this->gerePar;
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
