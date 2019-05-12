<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayerSms
 *
 * @ORM\Table(name="payer_sms", uniqueConstraints={@ORM\UniqueConstraint(name="unique_payer", columns={"abonnement", "mois", "annee"})}, indexes={@ORM\Index(name="montant", columns={"montant"}), @ORM\Index(name="id_user_pay", columns={"user"}), @ORM\Index(name="id_mois_pay", columns={"mois"}), @ORM\Index(name="date_pay", columns={"date"}), @ORM\Index(name="tel_abonne_pay", columns={"abonnement"})})
 * @ORM\Entity
 */
class PayerSms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="abonnement", type="integer", nullable=true)
     */
    private $abonnement;

    /**
     * @var integer
     *
     * @ORM\Column(name="mois", type="integer", nullable=false)
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
     * @ORM\Column(name="annee", type="date", nullable=false)
     */
    private $annee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=true)
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set abonnement
     *
     * @param integer $abonnement
     * @return PayerSms
     */
    public function setAbonnement($abonnement)
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    /**
     * Get abonnement
     *
     * @return integer 
     */
    public function getAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     * @return PayerSms
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return integer 
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return PayerSms
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
     * @param \DateTime $annee
     * @return PayerSms
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \DateTime 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PayerSms
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
     * Set user
     *
     * @param integer $user
     * @return PayerSms
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
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
