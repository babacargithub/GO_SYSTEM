<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", uniqueConstraints={@ORM\UniqueConstraint(name="reservation_unique", columns={"client", "depart"})}, indexes={@ORM\Index(name="fk_depart", columns={"depart"}), @ORM\Index(name="id", columns={"client"}), @ORM\Index(name="id_agent", columns={"agent"}), @ORM\Index(name="point_dep", columns={"point_dep"}), @ORM\Index(name="id_des", columns={"des"}), @ORM\Index(name="confirme", columns={"confirme"})})
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\ReservationRepository")
 */
class Reservation
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirme", type="boolean", nullable=false)
     */
    private $confirme;
    /**
     * @var boolean
     *
     * @ORM\Column(name="paye", type="boolean", nullable=false)
     */
    private $paye=false;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \GO\CaravaneBundle\Entity\PointDepart
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\PointDepart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="point_dep", referencedColumnName="id",nullable=false)
     * })
     */
    private $pointDep;

    /**
     * @var \GO\CaravaneBundle\Entity\Payer
     *
     * @ORM\OneToOne(targetEntity="GO\CaravaneBundle\Entity\Payer", mappedBy="res")
      
     */
    private $paiement;
    /**
     * @var \GO\CaravaneBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Client", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $client;

    /**
     * @var \GO\CaravaneBundle\Entity\Destination
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="des", referencedColumnName="id", nullable=false)
     * })
     */
    private $des;

    /**
     * @var \GO\CaravaneBundle\Entity\Depart
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Depart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="depart", referencedColumnName="id",nullable=false)
     * })
     */
    private $depart;

    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent", referencedColumnName="id",nullable=true)
     * })
     */
    private $agent;

 /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean", nullable=true)
     */
    private $online=false;
    /**
     * @var integer
     *
     * @ORM\Column(name="num_place", type="integer", nullable=true)
     */
    private $numPlace;
   

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Reservation
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
     * Set confirme
     *
     * @param boolean $confirme
     * @return Reservation
     */
    public function setConfirme($confirme)
    {
        $this->confirme = $confirme;

        return $this;
    }

    /**
     * Get confirme
     *
     * @return boolean 
     */
    public function getConfirme()
    {
        return $this->confirme;
    }

    /**
     * Set paye
     *
     * @param boolean $paye
     * @return Reservation
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pointDep
     *
     * @param \GO\CaravaneBundle\Entity\PointDepart $pointDep
     * @return Reservation
     */
    public function setPointDep(\GO\CaravaneBundle\Entity\PointDepart $pointDep)
    {
        $this->pointDep = $pointDep;

        return $this;
    }

    /**
     * Get pointDep
     *
     * @return \GO\CaravaneBundle\Entity\PointDepart 
     */
    public function getPointDep()
    {
        return $this->pointDep;
    }

    /**
     * Set paiement
     *
     * @param \GO\CaravaneBundle\Entity\Payer $paiement
     * @return Reservation
     */
    public function setPaiement(\GO\CaravaneBundle\Entity\Payer $paiement = null)
    {
        $this->paiement = $paiement;

        return $this;
    }

    /**
     * Get paiement
     *
     * @return \GO\CaravaneBundle\Entity\Payer 
     */
    public function getPaiement()
    {
        return $this->paiement;
    }

    /**
     * Set client
     *
     * @param \GO\CaravaneBundle\Entity\Client $client
     * @return Reservation
     */
    public function setClient(\GO\CaravaneBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \GO\CaravaneBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set des
     *
     * @param \GO\CaravaneBundle\Entity\Destination $des
     * @return Reservation
     */
    public function setDes(\GO\CaravaneBundle\Entity\Destination $des)
    {
        $this->des = $des;

        return $this;
    }

    /**
     * Get des
     *
     * @return \GO\CaravaneBundle\Entity\Destination 
     */
    public function getDes()
    {
        return $this->des;
    }

    /**
     * Set depart
     *
     * @param \GO\CaravaneBundle\Entity\Depart $depart
     * @return Reservation
     */
    public function setDepart(\GO\CaravaneBundle\Entity\Depart $depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return \GO\CaravaneBundle\Entity\Depart 
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set agent
     *
     * @param \GO\UserBundle\Entity\User $agent
     * @return Reservation
     */
    public function setAgent(\GO\UserBundle\Entity\User $agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \GO\UserBundle\Entity\User 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set online
     *
     * @param boolean $online
     * @return Reservation
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean 
     */
    public function getOnline()
    {
        return $this->online;
    }
    /**
     * Set numPlace
     *
     * @param integer $numPlace
     * @return Reservation
     */
    public function setNumPlace($num)
    {
        $this->numPlace=$num;

        return $this;
    }

    /**
     * Get numPlace
     *
     * @return numPlace 
     */
    public function getNumPlace()
    {
        return $this->numPlace;
    }
    public function getHeureDepart()
    {
       return $this->depart->getHeurePointDep($this->pointDep)->getHeureDepart();
    }
    public function getArretBus()
    {
       return $this->depart->getHeurePointDep($this->pointDep)->getArretBus();
    }
    public function isPaye()
    {
        return !is_null($this->paiement);
    }
}
