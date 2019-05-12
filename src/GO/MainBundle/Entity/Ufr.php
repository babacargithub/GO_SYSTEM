<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ufr
 *
 * @ORM\Table(name="ufr")
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\UfrRepository")
 */
class Ufr
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;
/**
         * @ORM\OneToMany(targetEntity="GO\MainBundle\Entity\Section", mappedBy="ufr")
         *
         * 
         */
        private $sections;

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
     * @return Ufr
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
