<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depense
 *
 * @ORM\Table(name="depense", indexes={@ORM\Index(name="poste_depense", columns={"poste_depense", "date"}), @ORM\Index(name="montant", columns={"montant"})})
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\DepenseRepository")
 */
class Depense
{
      /**
     * @var \GO\ShopBundle\Entity\Charge
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Charge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poste_depense", referencedColumnName="id",onDelete="NO ACTION",nullable=false)
     * })
     */
    private $charge;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

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
     * @return Depense
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
     * Set date
     *
     * @param \DateTime $date
     * @return Depense
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
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

    /**
     * Set charge
     *
     * @param \GO\ShopBundle\Entity\Charge $charge
     * @return Depense
     */
    public function setCharge(\GO\ShopBundle\Entity\Charge $charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return \GO\ShopBundle\Entity\Charge 
     */
    public function getCharge()
    {
        return $this->charge;
    }
}
