<?php

namespace GO\ClientBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * AbstractCompte
 *
 * @ORM\MappedSuperclass()
 * @UniqueEntity(fields={"number"}, message="Ce numéro de compte est déjà attribué à un client")
 **/
abstract class AbstractCompte
{
    

    /**
     * @var int
     *
     * @ORM\Column(name="account_number", type="bigint", unique=true)
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Le numéro du compte doit être d'une longueur de 8 charactères",
     *      maxMessage = "Le numéro du compte doit être d'une longueur de 8 charactères",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="digit", message="Le numéro de compte ne doit pas contenir de lettre")
     
     **/
   protected $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Assert\DateTime()
     */
    protected $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    protected $locked=false;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    protected $disabled=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="locked_at", type="datetime", nullable=true)
     */
    protected $lockedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="disabled_at", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $disabledAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="closed", type="boolean")
     */
    protected $closed=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closed_at", type="datetime", nullable=true)
     */
    protected $closedAt;
    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     */
    protected $createdBy;
    /**
     * @var \GO\UserBundle\Entity\TypeCompte
     *
     * @ORM\ManyToOne(targetEntity="GO\ClientBundle\Entity\TypeCompte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_compte", referencedColumnName="id", nullable=false)
     * })
     */
    protected $typeCompte;


    
    //========================== ISSERES =============
    
    public function isDisabled()
    {
        return (bool) $this->disabled;
    }
    //
    public function isLocked()
    {
        return (bool) $this->locked;
    }
    //
    public function isClosed()
    {
        return (bool) $this->closed;
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
     * Set number
     *
     * @param integer $number
     *
     * @return AbstractCompte
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AbstractCompte
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return AbstractCompte
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return AbstractCompte
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set lockedAt
     *
     * @param \DateTime $lockedAt
     *
     * @return AbstractCompte
     */
    public function setLockedAt($lockedAt)
    {
        $this->lockedAt = $lockedAt;

        return $this;
    }

    /**
     * Get lockedAt
     *
     * @return \DateTime
     */
    public function getLockedAt()
    {
        return $this->lockedAt;
    }

    /**
     * Set disabledAt
     *
     * @param \DateTime $disabledAt
     *
     * @return AbstractCompte
     */
    public function setDisabledAt($disabledAt)
    {
        $this->disabledAt = $disabledAt;

        return $this;
    }

    /**
     * Get disabledAt
     *
     * @return \DateTime
     */
    public function getDisabledAt()
    {
        return $this->disabledAt;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     *
     * @return AbstractCompte
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set closedAt
     *
     * @param \DateTime $closedAt
     *
     * @return AbstractCompte
     */
    public function setClosedAt($closedAt)
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    /**
     * Get closedAt
     *
     * @return \DateTime
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * Set createdBy
     *
     * @param \GO\UserBundle\Entity\User $createdBy
     *
     * @return AbstractCompte
     */
    public function setCreatedBy(\GO\UserBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \GO\UserBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set typeCompte
     *
     * @param \GO\ClientBundle\Entity\TypeCompte $typeCompte
     *
     * @return AbstractCompte
     */
    public function setTypeCompte(\GO\ClientBundle\Entity\TypeCompte $typeCompte)
    {
        $this->typeCompte = $typeCompte;

        return $this;
    }

    /**
     * Get typeCompte
     *
     * @return \GO\ClientBundle\Entity\TypeCompte
     */
    public function getTypeCompte()
    {
        return $this->typeCompte;
    }
    
    //==============custom functions===============
    public abstract function generateAccountNumber();
}
