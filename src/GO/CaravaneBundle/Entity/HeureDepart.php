<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HeureDepart
 *
 * @ORM\Table(name="heure_depart", uniqueConstraints={@ORM\UniqueConstraint(name="point_dep_unique", columns={"depart", "point_dep"})})
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\HeureDepartRepository")
 */
class HeureDepart
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
     * @var \GO\CaravaneBundle\Entity\Depart
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Depart", inversedBy="heuresDepart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="depart", referencedColumnName="id",nullable=false)
     * })
     */
    private $depart;
    /**
     * @var \GO\CaravaneBundle\Entity\PointDepart
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\PointDepart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="point_dep", referencedColumnName="id",nullable=false)
     * })
     */
    private $pointDep;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureDepart", type="time")
     */
    private $heureDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="arretBus", type="string", length=100, nullable=true)
     */
    private $arretBus;


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
     * Set heureDepart
     *
     * @param \DateTime $heureDepart
     * @return HeureDepart
     */
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    /**
     * Get heureDepart
     *
     * @return \DateTime 
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set arretBus
     *
     * @param string $arretBus
     * @return HeureDepart
     */
    public function setArretBus($arretBus)
    {
        $this->arretBus = $arretBus;

        return $this;
    }

    /**
     * Get arretBus
     *
     * @return string 
     */
    public function getArretBus()
    {
        return $this->arretBus;
    }

    /**
     * Set depart
     *
     * @param \GO\CaravaneBundle\Entity\Depart $depart
     * @return HeureDepart
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
     * Set pointDep
     *
     * @param \GO\CaravaneBundle\Entity\PointDepart $pointDep
     * @return HeureDepart
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
}
