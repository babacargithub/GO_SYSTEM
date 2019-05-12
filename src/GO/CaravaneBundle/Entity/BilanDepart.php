<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BilanDepart
 *
 * @ORM\Table(name="bilan_depart")
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\BilanDepartRepository")
 */
class BilanDepart
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
     * @ORM\Column(name="location", type="integer")
     */
    private $location;

    /**
     * @var integer
     *
     * @ORM\Column(name="Encaisse", type="integer")
     */
    private $encaisse;

     /**
     * @var \GO\CaravaneBundle\Entity\Depart
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Depart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="depart", referencedColumnName="id",nullable=false)
     * })
     */
    private $depart;

    /**
     * @var \GO\CaravaneBundle\Entity\Chauffeur
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Chauffeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chauffeur", referencedColumnName="id",nullable=false)
     * })
     */
    private $chauffeur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombreInscrit", type="integer")
     */
    private $nombreInscrit;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombrePresent", type="integer")
     */
    private $nombrePresent;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombreAbsent", type="integer")
     */
    private $nombreAbsent;

    /**
     * @var \GO\MainBundle\Entity\Employe
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Employe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent", referencedColumnName="id",nullable=false)
     * })
     */
    private $agent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="savedAt", type="datetime")
     */
    private $savedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $lastUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="termine", type="boolean")
     */
    private $termine=false;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text",nullable=true)
     */
    private $commentaires;

    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id",nullable=false)
     * })
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="bus", type="string")
     */
    private $bus;

    /**
     * @var \GO\CaravaneBundle\Entity\DepenseDepart
     *
     * @ORM\OneToMany(targetEntity="GO\CaravaneBundle\Entity\DepenseDepart", mappedBy="bilanDepart",cascade={"persist"})
    */
    private $depenses;
    

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->depenses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set location
     *
     * @param integer $location
     * @return BilanDepart
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return integer 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set encaisse
     *
     * @param integer $encaisse
     * @return BilanDepart
     */
    public function setEncaisse($encaisse)
    {
        $this->encaisse = $encaisse;

        return $this;
    }

    /**
     * Get encaisse
     *
     * @return integer 
     */
    public function getEncaisse()
    {
        return $this->encaisse;
    }

    /**
     * Set nombreInscrit
     *
     * @param integer $nombreInscrit
     * @return BilanDepart
     */
    public function setNombreInscrit($nombreInscrit)
    {
        $this->nombreInscrit = $nombreInscrit;

        return $this;
    }

    /**
     * Get nombreInscrit
     *
     * @return integer 
     */
    public function getNombreInscrit()
    {
        return $this->nombreInscrit;
    }

    /**
     * Set nombrePresent
     *
     * @param integer $nombrePresent
     * @return BilanDepart
     */
    public function setNombrePresent($nombrePresent)
    {
        $this->nombrePresent = $nombrePresent;

        return $this;
    }

    /**
     * Get nombrePresent
     *
     * @return integer 
     */
    public function getNombrePresent()
    {
        return $this->nombrePresent;
    }

    /**
     * Set nombreAbsent
     *
     * @param integer $nombreAbsent
     * @return BilanDepart
     */
    public function setNombreAbsent($nombreAbsent)
    {
        $this->nombreAbsent = $nombreAbsent;

        return $this;
    }

    /**
     * Get nombreAbsent
     *
     * @return integer 
     */
    public function getNombreAbsent()
    {
        return $this->nombreAbsent;
    }

    /**
     * Set savedAt
     *
     * @param \DateTime $savedAt
     * @return BilanDepart
     */
    public function setSavedAt($savedAt)
    {
        $this->savedAt = $savedAt;

        return $this;
    }

    /**
     * Get savedAt
     *
     * @return \DateTime 
     */
    public function getSavedAt()
    {
        return $this->savedAt;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return BilanDepart
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set termine
     *
     * @param boolean $termine
     * @return BilanDepart
     */
    public function setTermine($termine)
    {
        $this->termine = $termine;

        return $this;
    }

    /**
     * Get termine
     *
     * @return boolean 
     */
    public function getTermine()
    {
        return $this->termine;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     * @return BilanDepart
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set bus
     *
     * @param string $bus
     * @return BilanDepart
     */
    public function setBus($bus)
    {
        $this->bus = $bus;

        return $this;
    }

    /**
     * Get bus
     *
     * @return string 
     */
    public function getBus()
    {
        return $this->bus;
    }

    /**
     * Set depart
     *
     * @param \GO\CaravaneBundle\Entity\Depart $depart
     * @return BilanDepart
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
     * Set chauffeur
     *
     * @param \GO\CaravaneBundle\Entity\Chauffeur $chauffeur
     * @return BilanDepart
     */
    public function setChauffeur(\GO\CaravaneBundle\Entity\Chauffeur $chauffeur)
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    /**
     * Get chauffeur
     *
     * @return \GO\CaravaneBundle\Entity\Chauffeur 
     */
    public function getChauffeur()
    {
        return $this->chauffeur;
    }

    /**
     * Set agent
     *
     * @param \GO\MainBundle\Entity\Employe $agent
     * @return BilanDepart
     */
    public function setAgent(\GO\MainBundle\Entity\Employe $agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \GO\MainBundle\Entity\Employe 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set user
     *
     * @param \GO\UserBundle\Entity\User $user
     * @return BilanDepart
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

    /**
     * Add depenses
     *
     * @param \GO\CaravaneBundle\Entity\DepenseDepart $depenses
     * @return BilanDepart
     */
    public function addDepense(\GO\CaravaneBundle\Entity\DepenseDepart $depenses)
    {
        $this->depenses[] = $depenses;

        return $this;
    }

    /**
     * Remove depenses
     *
     * @param \GO\CaravaneBundle\Entity\DepenseDepart $depenses
     */
    public function removeDepense(\GO\CaravaneBundle\Entity\DepenseDepart $depenses)
    {
        $this->depenses->removeElement($depenses);
    }

    /**
     * Get depenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepenses()
    {
        return $this->depenses;
    }
    public function getTotalDepense()
    {
        $total=0;
         foreach($this->depenses as $depense)
         {
             $total=$total+$depense->getMontant();
         }
         return (int) $total;
        
    }
    public function getBenefice()
    {
        $benefice= $this->encaisse-$this->location-$this->getTotalDepense();
        return (int)$benefice;
    }
    public function __toString() {
        return $this->prenom.' '.$this->nom;
    }
}
