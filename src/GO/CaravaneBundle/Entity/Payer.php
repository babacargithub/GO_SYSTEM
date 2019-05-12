<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payer
 *
 * @ORM\Table(name="payer", uniqueConstraints={@ORM\UniqueConstraint(name="recu_pay", columns={"code_recu"})}, indexes={@ORM\Index(name="id_agent", columns={"agent"}), @ORM\Index(name="id_res", columns={"res"})})
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\PayerRepository")
 */
class Payer
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_recu", type="integer", nullable=false)
     */
    private $codeRecu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent", referencedColumnName="id")
     * })
     */
    private $agent;

    /**
     * @var \GO\CaravaneBundle\Entity\Reservation
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Reservation", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="res", referencedColumnName="id")
     * })
     */
    private $res;



    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Payer
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
     * Set montant
     *
     * @param integer $montant
     * @return Payer
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
     * Set codeRecu
     *
     * @param integer $codeRecu
     * @return Payer
     */
    public function setCodeRecu($codeRecu)
    {
        $this->codeRecu = $codeRecu;

        return $this;
    }

    /**
     * Get codeRecu
     *
     * @return integer 
     */
    public function getCodeRecu()
    {
        return $this->codeRecu;
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
     * Set agent
     *
     * @param \GO\UserBundle\Entity\User $agent
     * @return Payer
     */
    public function setAgent(\GO\UserBundle\Entity\User $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \UserBundle\Entity\User 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set res
     *
     * @param \GO\CaravaneBundle\Entity\Reservation $res
     * @return Payer
     */
    public function setRes(\GO\CaravaneBundle\Entity\Reservation $res = null)
    {
        $this->res = $res;

        return $this;
    }

    /**
     * Get res
     *
     * @return \GO\CaravaneBundle\Entity\Reservation 
     */
    public function getRes()
    {
        return $this->res;
    }
}
