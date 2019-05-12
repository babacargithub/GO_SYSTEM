<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReceptionTransfertProduit
 *
 * @ORM\Table(name="reception_transfert_produit")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\ReceptionTransfertProduitRepository")
 */
class ReceptionTransfertProduit
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
     * @var \GO\ShopBundle\Entity\TransfertProduit
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\TransfertProduit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transfert_produit", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $transfertProduit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;
    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="validated_by", referencedColumnName="id", nullable=true)
     * })
     */
    private $validatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfValidation", type="datetime", nullable=true)
     */
    private $dateOfValidation;


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
     * Set date
     *
     * @param \DateTime $date
     * @return ReceptionTransfertProduit
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
     * Set validated
     *
     * @param boolean $validated
     * @return ReceptionTransfertProduit
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set dateOfValidation
     *
     * @param \DateTime $dateOfValidation
     * @return ReceptionTransfertProduit
     */
    public function setDateOfValidation($dateOfValidation=null)
    {
        $this->dateOfValidation = $dateOfValidation;

        return $this;
    }

    /**
     * Get dateOfValidation
     *
     * @return \DateTime 
     */
    public function getDateOfValidation()
    {
        return $this->dateOfValidation;
    }
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * Set transfertProduit
     *
     * @param \GO\ShopBundle\Entity\TransfertProduit $transfertProduit
     * @return ReceptionTransfertProduit
     */
    public function setTransfertProduit(\GO\ShopBundle\Entity\TransfertProduit $transfertProduit)
    {
        $this->transfertProduit = $transfertProduit;

        return $this;
    }

    /**
     * Get transfertProduit
     *
     * @return \GO\ShopBundle\Entity\TransfertProduit 
     */
    public function getTransfertProduit()
    {
        return $this->transfertProduit;
    }

    /**
     * Set validatedBy
     *
     * @param \GO\UserBundle\Entity\User $validatedBy
     * @return ReceptionTransfertProduit
     */
    public function setValidatedBy(\GO\UserBundle\Entity\User $validatedBy = null)
    {
        $this->validatedBy = $validatedBy;

        return $this;
    }

    /**
     * Get validatedBy
     *
     * @return \GO\UserBundle\Entity\User 
     */
    public function getValidatedBy()
    {
        return $this->validatedBy;
    }
}
