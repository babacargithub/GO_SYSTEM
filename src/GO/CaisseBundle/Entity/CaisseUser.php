<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaisseUser
 *
 * @ORM\Table(name="caisse_user")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\CaisseUserRepository")
 */
class CaisseUser extends BaseClassCaisse
{
    const ACCES_NIVEAU_CAISSIER=1;
    const ACCES_NIVEAU_CHEF_CAISSE=2;
    const ACCES_NIVEAU_SUPERVISEUR=3;
    const ACCES_NIVEAU_ADMIN=4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \GO\CaisseBundle\Entity\Caisse
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Caissier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caissier", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $caissier;

    /**
     * @var bool
     *
     * @ORM\Column(name="allowed", type="boolean", nullable=true)
     */
    private $allowed=true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="openning_at", type="time", nullable=true)
     */
    private $openningAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closing_at", type="time", nullable=true)
     */
    private $closingAt;

    /**
     * @var int
     *
     * @ORM\Column(name="access_level", type="integer", nullable=true)
     */
    private $accessLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;
 

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set allowed
     *
     * @param boolean $allowed
     *
     * @return CaisseUser
     */
    public function setAllowed($allowed)
    {
        $this->allowed = $allowed;

        return $this;
    }

    /**
     * Get allowed
     *
     * @return bool
     */
    public function getAllowed()
    {
        return $this->allowed;
    }

    /**
     * Set openningAt
     *
     * @param \DateTime $openningAt
     *
     * @return CaisseUser
     */
    public function setOpenningAt($openningAt)
    {
        $this->openningAt = $openningAt;

        return $this;
    }

    /**
     * Get openningAt
     *
     * @return \DateTime
     */
    public function getOpenningAt()
    {
        return $this->openningAt;
    }

    /**
     * Set closingAt
     *
     * @param \DateTime $closingAt
     *
     * @return CaisseUser
     */
    public function setClosingAt($closingAt)
    {
        $this->closingAt = $closingAt;

        return $this;
    }

    /**
     * Get closingAt
     *
     * @return \DateTime
     */
    public function getClosingAt()
    {
        return $this->closingAt;
    }

    /**
     * Set accessLevel
     *
     * @param integer $accessLevel
     *
     * @return CaisseUser
     */
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get accessLevel
     *
     * @return int
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return CaisseUser
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CaisseUser
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
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return CaisseUser
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return CaisseUser
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    
    

    /**
     * Set caissier
     *
     * @param \GO\CaisseBundle\Entity\Caissier $caissier
     *
     * @return CaisseUser
     */
    public function setCaissier(\GO\CaisseBundle\Entity\Caissier $caissier)
    {
        $this->caissier = $caissier;

        return $this;
    }

    /**
     * Get caissier
     *
     * @return \GO\CaisseBundle\Entity\Caissier
     */
    public function getCaissier()
    {
        return $this->caissier;
    }
    
    //================fonctions diverses =============//
    
    public function isAllowed()
    {
        return $this->allowed;
    }
}
