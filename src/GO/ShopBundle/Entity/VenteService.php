<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VenteService
 *
 * @ORM\Table(name="vente_service", indexes={@ORM\Index(name="service", columns={"service", "date"}), @ORM\Index(name="index_date_vente_service", columns={"date"})})
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\VenteServiceRepository")
 */
class VenteService extends BaseClass
{
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Service")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="service", referencedColumnName="id", onDelete="NO ACTION", nullable=false)})
     */
    private $service;

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
     * @return VenteService
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
     * @return VenteService
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
    public function __construct() {
        $this->date=new \DateTime;
    }

    /**
     * Set service
     *
     * @param \GO\ShopBundle\Entity\Service $service
     * @return VenteService
     */
    public function setService(\GO\ShopBundle\Entity\Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \GO\ShopBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
}
