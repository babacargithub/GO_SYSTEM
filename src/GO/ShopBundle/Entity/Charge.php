<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Charge
 *
 * @ORM\Table(name="charge_shop")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\ChargeRepository")
 */
class Charge
{
    const CHARGE_FIXE=1;
    const CHARGE_VARIABLE=2;
    const CHARGE_APPOVRISSANTE=1;
    const CHARGE_NON_APPOVRISSANTE=2;
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=false)
     */ 
    private $libelle;
    /**
     * @var string
     *
     * @ORM\Column(name="fixe", type="boolean", nullable=false)
     */
    private $fixe;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Charge
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
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

   
    
    public function __toString() {
        return $this->libelle;
    }

    /**
     * Set fixe
     *
     * @param boolean $fixe
     *
     * @return Charge
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;

        return $this;
    }

    /**
     * Get fixe
     *
     * @return boolean
     */
    public function getFixe()
    {
        return $this->fixe;
    }
    
    public function isFixe()
    {
        return $this->getFixe();
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Charge
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}
