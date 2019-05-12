<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DepenseDepart
 *
 * @ORM\Table(name="depense_depart")
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\DepenseDepartRepository")
 */
class DepenseDepart
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
     * @var \GO\CaravaneBundle\Entity\BilanDepart
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\BilanDepart", inversedBy="depenses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bilan_depart", referencedColumnName="id",nullable=false)
     * })
     */

    private $bilanDepart;

    /**
     * @var \GO\ShopBundle\Entity\PosteDepense
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Charge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="depense", referencedColumnName="id",nullable=false)
     * })
     */
    private $depense;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer",nullable=false)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="justification", type="string", length=255)
     */
    private $justification;

    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;

    

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
     * Set montant
     *
     * @param integer $montant
     * @return DepenseDepart
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
     * Set justification
     *
     * @param string $justification
     * @return DepenseDepart
     */
    public function setJustification($justification)
    {
        $this->justification = $justification;

        return $this;
    }

    /**
     * Get justification
     *
     * @return string 
     */
    public function getJustification()
    {
        return $this->justification;
    }

    /**
     * Set bilanDepart
     *
     * @param \GO\CaravaneBundle\Entity\BilanDepart $bilanDepart
     * @return DepenseDepart
     */
    public function setBilanDepart(\GO\CaravaneBundle\Entity\BilanDepart $bilanDepart)
    {
        $this->bilanDepart = $bilanDepart;

        return $this;
    }

    /**
     * Get bilanDepart
     *
     * @return \GO\CaravaneBundle\Entity\BilanDepart 
     */
    public function getBilanDepart()
    {
        return $this->bilanDepart;
    }

    /**
     * Set depense
     *
     * @param \GO\ShopBundle\Entity\PosteDepense $depense
     * @return DepenseDepart
     */
    public function setDepense(\GO\CaravaneBundle\Entity\Charge $depense)
    {
        $this->depense = $depense;

        return $this;
    }

    /**
     * Get depense
     *
     * @return \GO\ShopBundle\Entity\PosteDepense 
     */
    public function getDepense()
    {
        return $this->depense;
    }

    /**
     * Set user
     *
     * @param \GO\UserBundle\Entity\User $user
     * @return DepenseDepart
     */
    public function setUser(\GO\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GO\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
