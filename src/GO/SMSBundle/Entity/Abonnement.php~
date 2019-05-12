<?php

namespace  GO\SMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", uniqueConstraints={@ORM\UniqueConstraint(name="id_client_abnmnt_2", columns={"client"})}, indexes={@ORM\Index(name="type_abnmnt", columns={"formule"}), @ORM\Index(name="challenger_id", columns={"challenger"})})
 * @ORM\Entity(repositoryClass="GO\SMSBundle\Entity\AbonnementRepositoty")
 */
class Abonnement extends BaseClass
{
   
     /**
     * @var \GO\MainBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $client;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expir", type="datetime", nullable=false)
     */
    private $dateExpir;

      /**
     * @var \GO\SMSBundle\Entity\Formule    
     *
     * @ORM\ManyToOne(targetEntity="GO\SMSBundle\Entity\Formule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formule", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $formule;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif=true;
    /**
     * @var \GO\MainBundle\Entity\Challenger
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Client", inversedBy="abonnements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="challenger", referencedColumnName="id",onDelete="CASCADE", nullable=true)
     * })
     */
    private $challenger;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Abonnement
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
     * Set dateExpir
     *
     * @param \DateTime $dateExpir
     * @return Abonnement
     */
    public function setDateExpir($dateExpir)
    {
        $this->dateExpir = $dateExpir;

        return $this;
    }

    /**
     * Get dateExpir
     *
     * @return \DateTime 
     */
    public function getDateExpir()
    {
        return $this->dateExpir;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Abonnement
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
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
     * Set client
     *
     * @param \GO\MainBundle\Entity\Client $client
     * @return Abonnement
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

    /**
     * Set challenger
     *
     * @param \GO\MainBundle\Entity\Client $challenger
     * @return Abonnement
     */
    public function setChallenger(\GO\MainBundle\Entity\Client $challenger = null)
    {
        $this->challenger = $challenger;

        return $this;
    }

    /**
     * Get challenger
     *
     * @return \GO\MainBundle\Entity\Client 
     */
    public function getChallenger()
    {
        return $this->challenger;
    }

    /**
     * Set formule
     *
     * @param \GO\SMSBundle\Entity\Formule $formule
     * @return Abonnement
     */
    public function setFormule(\GO\SMSBundle\Entity\Formule $formule)
    {
        $this->formule = $formule;

        return $this;
    }

    /**
     * Get formule
     *
     * @return \GO\SMSBundle\Entity\Formule 
     */
    public function getFormule()
    {
        return $this->formule;
    }
}
