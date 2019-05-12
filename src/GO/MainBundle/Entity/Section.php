<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\SectionRepository")
 */
class Section
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var \GO\MainBundle\Entity\Ufr
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Ufr")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ufr", referencedColumnName="id",onDelete="CASCADE",nullable=true)
     * })
     */
    private $ufr;

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
     * @return Section
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
     * Set ufr
     *
     * @param integer $ufr
     * @return Section
     */
    public function setUfr($ufr)
    {
        $this->ufr = $ufr;

        return $this;
    }

    /**
     * Get ufr
     *
     * @return integer 
     */
    public function getUfr()
    {
        return $this->ufr;
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
