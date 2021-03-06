<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetteFacture
 *
 * @ORM\Table(name="dette_facture")
 *  @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\DetteFactureRepository")
 */
class DetteFacture extends Dette
{
    /**
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\FactureAchat")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="facture", referencedColumnName="id")})
     */
    private $facture;
    /**
     * @var integer
     *
     * @ORM\Column(name="avance", type="integer", nullable=true)
     */
    private $avance;
    

    /**
     * Set facture
     *
     * @param \GO\ShopBundle\Entity\FactureAchat $facture
     * @return DetteFacture
     */
    public function setFacture(\GO\ShopBundle\Entity\FactureAchat $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \GO\ShopBundle\Entity\FactureAchat 
     */
    public function getFacture()
    {
        return $this->facture;
    }
    public function getRestant()
    {
        return (int)$this->facture->getTotal()-$this->getAvance();
    }

    /**
     * Set avance
     *
     * @param integer $avance
     *
     * @return DetteFacture
     */
    public function setAvance($avance)
    {
        $this->avance = $avance;

        return $this;
    }

    /**
     * Get avance
     *
     * @return integer
     */
    public function getAvance()
    {
        return $this->avance;
    }
}
