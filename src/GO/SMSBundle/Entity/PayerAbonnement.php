<?php

namespace  GO\SMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayerSms
 *
 * @ORM\Table(name="payer_abnmnt_sms", uniqueConstraints={@ORM\UniqueConstraint(name="unique_payer", columns={"abonnement", "mois", "annee"})}))
 * @ORM\Entity(repositoryClass="GO\SMSBundle\Entity\PayerAbonnementRepository")
 */
class PayerAbonnement extends BaseClass
{
    /**
     * @var \GO\SMSBundle\Entity\Abonnement
     *
     * @ORM\ManyToOne(targetEntity="GO\SMSBundle\Entity\Abonnement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="abonnement", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $abonnement;
     /**
     * @var \GO\MainBundle\Entity\Mois
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Mois")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mois", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $mois;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="annee", type="string",length=4, nullable=false)
     */
    private $annee;

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
    public function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return PayerAbonnement
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
     * Set annee
     *
     * @param $annee
     * @return PayerAbonnement
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \year 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PayerAbonnement
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
     * Set abonnement
     *
     * @param \GO\SMSBundle\Entity\Abonnement $abonnement
     * @return PayerAbonnement
     */
    public function setAbonnement(\GO\SMSBundle\Entity\Abonnement $abonnement)
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    /**
     * Get abonnement
     *
     * @return \GO\SMSBundle\Entity\Abonnement 
     */
    public function getAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * Set mois
     *
     * @param \GO\MainBundle\Entity\Mois $mois
     * @return PayerAbonnement
     */
    public function setMois(\GO\MainBundle\Entity\Mois $mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return \GO\MainBundle\Entity\Mois 
     */
    public function getMois()
    {
        return $this->mois;
    }
}
