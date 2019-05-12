<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perte
 *
 * @ORM\Table(name="perte")
 * @ORM\Entity
 */
class Perte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="cause", type="string", length=255, nullable=true)
     */
    private $cause;

    /**
     * @var string
     *
     * @ORM\Column(name="extra", type="string", length=255, nullable=true)
     */
    private $extra;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set montant
     *
     * @param integer $montant
     * @return Perte
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set cause
     *
     * @param string $cause
     * @return Perte
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause
     *
     * @return string 
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set extra
     *
     * @param string $extra
     * @return Perte
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra
     *
     * @return string 
     */
    public function getExtra()
    {
        return $this->extra;
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
