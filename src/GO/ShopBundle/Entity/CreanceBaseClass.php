<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\MappedSuperclass() */
class CreanceBaseClass extends BaseClass {
    const CREANCE_REMBOURSE=true, 
          CREANCE_NON_REMBOURSE=false;

    /**
     * @var \GO\MainBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Client", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id",onDelete="NO ACTION", nullable=false)
     * })
     */
    private $client;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creance", type="datetime", nullable=false)
     */
    private $dateCreance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_echeance", type="datetime", nullable=true)
     */
    private $dateEcheance;
    /**
     * @var boolean
     *
     * @ORM\Column(name="rembourse", type="boolean", nullable=false)
     */
    private $rembourse=false;

    
    public function __construct() {
        $this->dateCreance = new \DateTime();
    }

    
    /**
     * Set dateCreance
     *
     * @param \DateTime $dateCreance
     * @return Creance
     */
    public function setDateCreance($dateCreance)
    {
        $this->dateCreance = $dateCreance;

        return $this;
    }

    /**
     * Get dateCreance
     *
     * @return \DateTime 
     */
    public function getDateCreance()
    {
        return $this->dateCreance;
    }

    /**
     * Set dateEcheance
     *
     * @param \DateTime $dateEcheance
     * @return Creance
     */
    public function setDateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    /**
     * Get dateEcheance
     *
     * @return \DateTime 
     */
    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }

    /**
     * Set rembourse
     *
     * @param boolean $rembourse
     * @return Creance
     */
    public function setRembourse($rembourse)
    {
        $this->rembourse = $rembourse;

        return $this;
    }

    /**
     * Get rembourse
     *
     * @return boolean 
     */
    public function getRembourse()
    {
        return $this->rembourse;
    }
 
    /**
     * @return bool
     */
    public function isPasse()
    {
        $currentDate=new \DateTime();
        return $this->dateEcheance <$currentDate ;
    }

  
    /**
     * Set client
     *
     * @param \GO\MainBundle\Entity\Client $client
     * @return CreanceBaseClass
     */
    public function setClient(\GO\MainBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \GO\MainBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }
}
