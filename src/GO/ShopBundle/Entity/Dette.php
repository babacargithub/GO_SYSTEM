<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dette
 *
 * @ORM\MappedSuperclass()
 */
class Dette extends BaseClass
{
    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_dette", type="datetime", nullable=false)
     */
    private $dateDette;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_echeance", type="datetime", nullable=false)
     */
    private $dateEcheance;

    
    /**
     * @var boolean
     *
     * @ORM\Column(name="rembourse", type="boolean", nullable=false)
     */
    private $rembourse=false;
    /**
     * @var boolean
     *
     * @ORM\Column(name="rembourseAt", type="date", nullable=true)
     */
    private $rembourseAt=null;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    public function __construct() {
        $this->dateDette = new \DateTime();
        
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return Dette
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
     * Set dateDette
     *
     * @param \DateTime $dateDette
     * @return Dette
     */
    public function setDateDette($dateDette)
    {
        $this->dateDette = $dateDette;

        return $this;
    }

    /**
     * Get dateDette
     *
     * @return \DateTime 
     */
    public function getDateDette()
    {
        return $this->dateDette;
    }

    /**
     * Set dateEcheance
     *
     * @param \DateTime $dateEcheance
     * @return Dette
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
     * @return Dette
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
