<?php

namespace  GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Charge
 *
 * @ORM\Table(name="charge_caravane")
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\ChargeRepository")
 */
class Charge
{
    const CHARGE_FIXE=true;
    const CHARGE_VARIABLE=false;
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=false)
     */ 
    private $libelle;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $fixe;

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
     * @return Charge
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   
    
    public function __toString() {
        return $this->libelle;
    }

    /**
     * Set fixe
     *
     * @param boolean $fixe
     *
     * @return Charge
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;

        return $this;
    }

    /**
     * Get fixe
     *
     * @return boolean
     */
    public function getFixe()
    {
        return $this->fixe;
    }
    
    public function isFixe()
    {
        return $this->getFixe();
    }
}
