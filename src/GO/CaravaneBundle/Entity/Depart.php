<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Depart
 *
 * @ORM\Table(name="depart", uniqueConstraints={@ORM\UniqueConstraint(name="libelle_depart", columns={"libelle", "date", "trajet", "event"})}, indexes={@ORM\Index(name="id_event_depart", columns={"event"})})
 * @ORM\Entity(repositoryClass="GO\CaravaneBundle\Entity\DepartRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Depart
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="horaire", type="integer", nullable=true)
     */
    private $horaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="trajet", type="integer", nullable=true)
     */
    private $trajet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="clos_res", type="boolean", nullable=false)
     */
    private $closRes=false;
    /**
     * @var boolean
     *
     * @ORM\Column(name="clos_paye", type="boolean", nullable=false)
     */
    private $closPaye=false;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \GO\CaravaneBundle\Entity\Evenement
     *
     * @ORM\ManyToOne(targetEntity="GO\CaravaneBundle\Entity\Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event", referencedColumnName="id")
     * })
     */
    private $event;
    /**
     * @var \GO\CaravaneBundle\Entity\Evenement
     *
     * @ORM\OneToMany(targetEntity="GO\CaravaneBundle\Entity\HeureDepart", mappedBy="depart",cascade={"persist"})
    */
    private $heuresDepart;

     /**
     * @var \GO\CaravaneBundle\Entity\BilanDepart
     *
     * @ORM\OneToOne(targetEntity="GO\CaravaneBundle\Entity\BilanDepart", mappedBy="depart")
    */
    private $bilan;

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Depart
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
     * Set date
     *
     * @param \DateTime $date
     * @return Depart
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
     * Set trajet
     *
     * @param integer $trajet
     * @return Depart
     */
    public function setTrajet($trajet)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return integer 
     */
    public function getTrajet()
    {
        return $this->trajet;
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
     * Set event
     *
     * @param \GO\CaravaneBundle\Entity\Evenement $event
     * @return Depart
     */
    public function setEvent(\GO\CaravaneBundle\Entity\Evenement $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \GO\CaravaneBundle\Entity\Evenement 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set closRes
     *
     * @param boolean $closRes
     * @return Depart
     */
    public function setClosRes($closRes)
    {
        $this->closRes = $closRes;

        return $this;
    }

    /**
     * Get closRes
     *
     * @return boolean 
     */
    public function getClosRes()
    {
        return $this->closRes;
    }

    /**
     * Set closPaye
     *
     * @param boolean $closPaye
     * @return Depart
     */
    public function setClosPaye($closPaye)
    {
        $this->closPaye = $closPaye;

        return $this;
    }

    /**
     * Get closPaye
     *
     * @return boolean 
     */
    public function getClosPaye()
    {
        return $this->closPaye;
    }

    /**
     * Set horaire
     *
     * @param integer $horaire
     * @return Depart
     */
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get horaire
     *
     * @return integer 
     */
    public function getHoraire()
    {
        return $this->horaire;
    }
    /**
     * @return bool
     */
    public function isPasse()
    {
        $currentDate=new \DateTime();
        return $currentDate > $this->getDate();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->heuresDepart = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add heuresDepart
     *
     * @param \GO\CaravaneBundle\Entity\HeureDepart $heuresDepart
     * @return Depart
     */
    public function addHeuresDepart(\GO\CaravaneBundle\Entity\HeureDepart $heuresDepart)
    {
        $this->heuresDepart[] = $heuresDepart;

        return $this;
    }

    /**
     * Remove heuresDepart
     *
     * @param \GO\CaravaneBundle\Entity\HeureDepart $heuresDepart
     */
    public function removeHeuresDepart(\GO\CaravaneBundle\Entity\HeureDepart $heuresDepart)
    {
        $this->heuresDepart->removeElement($heuresDepart);
    }

    /**
     * Get heuresDepart
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHeuresDepart()
    {
        return $this->heuresDepart;
    }
    // fonction pour récupérer l'heure de départ d'un point de départ doné
    public function getHeurePointDep(PointDepart $pointDep)
    {
        $criteria = Criteria::create()
    ->where(Criteria::expr()->eq("pointDep", $pointDep))
    ->setMaxResults(1);
        return $this->getHeuresDepart()->matching($criteria)[0];
    }
    
    public function isResClos()
    {
        return $this->closRes;
    }
    public function isPayeClos()
    {
        return $this->closPaye;
    }
    /**
     * @ORM\PreUpdate()
     * @return type
     */
    public function setEndTime()
    {
         if($this->getHoraire()==1)
       {
       if($this->getTrajet()==2)
        $this->date->setTime(03,59);
           else
        $this->date->setTime(23,59);
       }
       elseif($this->getHoraire()==2)
       {
            $this->date->setTime(15,30);
       }
    }
    public function __toString() {
        return ucfirst($this->libelle);
    }

    /**
     * Set bilan
     *
     * @param \GO\CaravaneBundle\Entity\BialnDepart $bilan
     * @return Depart
     */
    public function setBilan($bilan = null)
    {
        $this->bilan = $bilan;

        return $this;
    }

    /**
     * Get bilan
     *
     * @return \GO\CaravaneBundle\Entity\BialnDepart 
     */
    public function getBilan()
    {
        return $this->bilan;
    }
}
