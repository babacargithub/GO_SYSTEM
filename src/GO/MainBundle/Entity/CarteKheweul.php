<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarteKheweul
 *
 * @ORM\Table(name="cartekheweul", uniqueConstraints={@ORM\UniqueConstraint(name="num_carte", columns={"num_carte"})})
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\CarteKheweulRepository")
 */
class CarteKheweul
{
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
     * @ORM\Column(name="num_carte", type="bigint")
     */
    private $numCarte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deliv", type="datetime")
     */
    private $dateDeliv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_exp", type="datetime")
     */
    private $dateExp;
    /**
     * @var \GO\MainBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $client;

    /**
     * @var \GO\MainBundle\Entity\TypeCarte
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\TypeCarte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $type;
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active=true;


    /**
     * Get id
     *
     * @return integer 
     */
    public function __construct() {
        $this->dateDeliv= new \DateTime();
    }
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numCarte
     *
     * @param integer $numCarte
     * @return CarteKheweul
     */
    public function setNumCarte($numCarte)
    {
        $this->numCarte = $numCarte;

        return $this;
    }

    /**
     * Get numCarte
     *
     * @return integer 
     */
    public function getNumCarte()
    {
        return $this->numCarte;
    }

    /**
     * Set dateDeliv
     *
     * @param \DateTime $dateDeliv
     * @return CarteKheweul
     */
    public function setDateDeliv($dateDeliv)
    {
        $this->dateDeliv = $dateDeliv;

        return $this;
    }

    /**
     * Get dateDeliv
     *
     * @return \DateTime 
     */
    public function getDateDeliv()
    {
        return $this->dateDeliv;
    }

    /**
     * Set dateExp
     *
     * @param \DateTime $dateExp
     * @return CarteKheweul
     */
    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;

        return $this;
    }

    /**
     * Get dateExp
     *
     * @return \DateTime 
     */
    public function getDateExp()
    {
        return $this->dateExp;
    }

    
    /**
     * Set client
     *
     * @param \GO\CaravaneBundle\Entity\Client $client
     * @return CarteKheweul
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
     * Set active
     *
     * @param boolean $active
     * @return CarteKheweul
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set type
     *
      @param \GO\CaravaneBundle\Entity\TypeCarte $type
     * @return CarteKheweul
     */
    public function setType(\GO\MainBundle\Entity\TypeCarte $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \GO\MainBundle\Entity\TypeCarte
     */
    public function getType()
    {
        return $this->type;
    }
}
