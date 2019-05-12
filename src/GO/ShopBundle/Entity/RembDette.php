<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RembDette
 *
 * @ORM\Table(name="remb_dette")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\RembDetteRepository")
 */
//==============Entité représentant les remboursements des créances 
class RembDette extends BaseClass
{
    /**
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\DetteLiquide", inversedBy="remboursements")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="dette", referencedColumnName="id", nullable=false)})
     */
    private $dette;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

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


    /**
     * Set montant
     *
     * @param integer $montant
     * @return RembDette
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
     * Set date
     *
     * @param \DateTime $date
     * @return RembDette
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
     * Set dette
     *
     * @param \GO\ShopBundle\Entity\Dette $dette
     * @return RembDette
     */
    public function setDette(\GO\ShopBundle\Entity\Dette $dette)
    {
        $this->dette = $dette;

        return $this;
    }

    /**
     * Get dette
     *
     * @return \GO\ShopBundle\Entity\Dette
     */
    public function getDette()
    {
        return $this->dette;
    }
}
