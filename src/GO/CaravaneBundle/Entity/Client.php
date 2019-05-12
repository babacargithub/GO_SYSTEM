<?php

namespace  GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GO\ClientBundle\Entity\Client as BaseClient;

/**
 * Client
 *
 * @ORM\Table(name="caravane_client")
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\ClientRepository")
 */
class Client
{
    

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
      * @var \GO\ClientBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="GO\ClientBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="coordonnees", referencedColumnName="id", nullable=false)
     * })
     */
    private $coordonnees;
     /**
         * @ORM\OneToMany(targetEntity="GO\CaravaneBundle\Entity\Reservation", mappedBy="client")
         *
         * 
         */
    private $reservations;


    public function __construct() {
        $this->reservations= new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __call($method, $arguments)
    {
        $reflect=new \ReflectionClass("\GO\ClientBundle\Entity\Client");
        if($reflect->hasMethod($method))
        {
            return ($this->coordonnees!=null)?$this->coordonnees->$method():null;
        }
        elseif($reflect->hasMethod("get".ucfirst($method)))
        {
            $method="get".ucfirst ($method);
            return ($this->coordonnees!=null)?$this->coordonnees->$method():null;
       
        }else
        {
            throw new \BadMethodCallException("Methode inexistane!");
        }
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
     * Set coordonnees
     *
     * @param \GO\ClientBundle\Entity\Client $coordonnees
     *
     * @return Client
     */
    public function setCoordonnees(\GO\ClientBundle\Entity\Client $coordonnees)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees
     *
     * @return \GO\ClientBundle\Entity\Client
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * Add reservation
     *
     * @param \GO\CaravaneBundle\Entity\Reservation $reservation
     *
     * @return Client
     */
    public function addReservation(\GO\CaravaneBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \GO\CaravaneBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\GO\CaravaneBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
