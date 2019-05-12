<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RemiseCarte
 *
 * @ORM\Table(name="remisecarte", uniqueConstraints={@ORM\UniqueConstraint(name="promo", columns={"carte", "promo"})})

 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\RemiseCarteRepository")
 */
class RemiseCarte
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
     * @var GO\MainBundle\Entity\TypeCarte
     *@ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\TypeCarte")
     * @ORM\JoinColumns(@ORM\JoinColumn(name="carte", referencedColumnName="id", onDelete="CASCADE"))
     */
    private $carte;

    /**
     * @var GO\MainBundle\Entity\Promo
     *@ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Promo")
     * @ORM\JoinColumns(@ORM\JoinColumn(name="promo", referencedColumnName="id", onDelete="CASCADE"))
     */
    private $promo;

    /**
     * @var integer
     *
     * @ORM\Column(name="tauxRemise", type="integer")
     */
    private $tauxRemise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;


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
     * Set carte
     *
     * @param GO\MainBundle\Entity\TypeCarte $carte
     * @return RemiseCarte
     */
    public function setCarte(\GO\MainBundle\Entity\TypeCarte $carte)
    {
        $this->carte = $carte;

        return $this;
    }

    /**
     * Get carte
     *
     * @return integer 
     */
    public function getCarte()
    {
        return $this->carte;
    }

    /**
     * Set promo
     *
     * @param GO\MainBundle\Entity\Promo
     * @return RemiseCarte
     */
    public function setPromo(\GO\MainBundle\Entity\Promo $promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return integer 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set tauxRemise
     *
     * @param integer $tauxRemise
     * @return RemiseCarte
     */
    public function setTauxRemise($tauxRemise)
    {
        $this->tauxRemise = $tauxRemise;

        return $this;
    }

    /**
     * Get tauxRemise
     *
     * @return integer 
     */
    public function getTauxRemise()
    {
        return $this->tauxRemise;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return RemiseCarte
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
    public function isPasse()
    {
        $currentDate=new \DateTime();
        return $currentDate > $this->getDateFin();
    }
}
