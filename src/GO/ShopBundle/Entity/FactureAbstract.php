<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dette
 *
 * @ORM\MappedSuperclass()
 */
class FactureAbstract extends BaseClass
{
    const FACTURE_PAYE=true;
    const FACTURE_NON_PAYE=false;
    const FACTURE_PAYE_ET_NON_PAYE=null;
    const FACTURE_LIVRE=true;
    const FACTURE_NON_LIVRE=false;
    const FACTURE_ECHEANCE_PASSE=true;
    const FACTURE_ECHEANCE_NON_PASSE=false;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="num", type="integer")
     */
    private $num;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fact", type="datetime", nullable=true)
     */
    private $dateFacture;

   
    /**
     * @var boolean
     *
     * @ORM\Column(name="paye", type="boolean", nullable=false)
     */
    private $paye;

    /**
     * @var integer
     *
     * @ORM\Column(name="avance", type="integer", nullable=true)
     */
    private $avance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="livre", type="boolean")
     */
    private $livre;
    /**
     * @var boolean
     *
     * @ORM\Column(name="dete_echeance", type="datetime", nullable=true)
     */
    private $dateEcheance;
    /**
     * @var boolean
     *
     * @ORM\Column(name="last_paye", type="datetime", nullable=true)
     */
    private $dernierPayment;
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="validated_at", type="datetime", nullable=true)
     */
    private $validated_At;

   
    /**
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     */
    private $validated;

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
     * Set num
     *
     * @param integer $num
     * @return FactureAchat
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return FactureAchat
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
     * Set paye
     *
     * @param boolean $paye
     * @return FactureAchat
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;

        return $this;
    }

    /**
     * Get paye
     *
     * @return boolean 
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * Set avance
     *
     * @param integer $avance
     * @return FactureAchat
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

    /**
     * Set livre
     *
     * @param boolean $livre
     * @return FactureAchat
     */
    public function setLivre($livre)
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * Get livre
     *
     * @return boolean 
     */
    public function getLivre()
    {
        return $this->livre;
    }

  
    /**
     * Constructor
     */
    public function __construct()
    {
         $this->date = new \DateTime();
    }

  
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime 
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }
    

    /**
     * Set dateEcheance
     *
     * @param \DateTime $dateEcheance
     *
     * @return FactureAbstract
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
     * Set dernierPayment
     *
     * @param \DateTime $dernierPayment
     *
     * @return FactureAbstract
     */
    public function setDernierPayment($dernierPayment)
    {
        $this->dernierPayment = $dernierPayment;

        return $this;
    }

    /**
     * Get dernierPayment
     *
     * @return \DateTime
     */
    public function getDernierPayment()
    {
        return $this->dernierPayment;
    }

    /**
     * Set validatedAt
     *
     * @param \DateTime $validatedAt
     *
     * @return FactureAbstract
     */
    public function setValidatedAt($validatedAt)
    {
        $this->validated_At = $validatedAt;

        return $this;
    }

    /**
     * Get validatedAt
     *
     * @return \DateTime
     */
    public function getValidatedAt()
    {
        return $this->validated_At;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     *
     * @return FactureAbstract
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }
    
    //========issers=============
    public function isPaye(){ return $this->getPaye();}
    public function isLivre(){ return $this->getLivre();}
    public function isValidated(){ return $this->getValidated();}
}
