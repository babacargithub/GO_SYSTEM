<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client", uniqueConstraints={@ORM\UniqueConstraint(name="tel", columns={"tel"}), @ORM\UniqueConstraint(name="bloc", columns={"bloc"})}, indexes={@ORM\Index(name="date_client", columns={"date"}), @ORM\Index(name="promo_client", columns={"promo"}), @ORM\Index(name="sexe", columns={"sexe", "ufr", "section", "niveau", "village", "user"}), @ORM\Index(name="user", columns={"user", "village", "ufr", "bloc"}), @ORM\Index(name="village", columns={"village"}), @ORM\Index(name="IDX_C74404558D93D649", columns={"user"})})
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\ClientRepository")
 */
class Client
{
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="bigint", unique=true, nullable=false)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="promo", type="string", length=3, nullable=true)
     */
    private $promo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @var \GO\MainBundle\Entity\Ufr
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Ufr")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ufr", referencedColumnName="id",onDelete="CASCADE",nullable=true)
     * })
     */
    private $ufr;

    /**
     * @var \GO\MainBundle\Entity\Section
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section", referencedColumnName="id",onDelete="CASCADE",nullable=true)
     * })
     */
    private $section;

    /**
     * @var integer
     *
     * @ORM\Column(name="niveau", type="integer", nullable=true)
     */
    private $niveau;

    /**
     * @var integer
     *
     * @ORM\Column(name="chambre", type="integer", nullable=true)
     */
    private $chambre;
    /**
     * @var integer
     *
     * @ORM\Column(name="disabled", type="boolean", nullable=true)
     */
    private $disabled=false;
    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active=true;
    /**
     * @var integer
     *
     * @ORM\Column(name="lastActive", type="datetime", nullable=true)
     */
    private $lastActive;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=256, nullable=true)
     */
    private $tags;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
      * @var \GO\MainBundle\Entity\Village
     *
     * @ORM\ManyToOne(targetEntity="\GO\MainBundle\Entity\Village")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="village", referencedColumnName="id")
     * })
     */
    private $village;

    /**
      * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
      * @var \GO\MainBundleEntity\Bloc
     *
     * @ORM\ManyToOne(targetEntity="GO\MainBundle\Entity\Bloc")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bloc", referencedColumnName="id")
     * })
     */
    private $bloc;
    
    /**
         * @ORM\OneToMany(targetEntity="GO\CaravaneBundle\Entity\Reservation", mappedBy="client")
         *
         * 
         */
        private $reservations;


    public function __construct() {
        $this->reservations= new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     * @return Client
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set promo
     *
     * @param string $promo
     * @return Client
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return string 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Client
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
     * Set sexe
     *
     * @param string $sexe
     * @return Client
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }


    /**
     * Set niveau
     *
     * @param integer $niveau
     * @return Client
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set chambre
     *
     * @param integer $chambre
     * @return Client
     */
    public function setChambre($chambre)
    {
        $this->chambre = $chambre;

        return $this;
    }

    /**
     * Get chambre
     *
     * @return integer 
     */
    public function getChambre()
    {
        return $this->chambre;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Client
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
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
     * Set village
     *
     * @param \GO\MainBundle\Entity\Village $village
     * @return Client
     */
    public function setVillage(\GO\MainBundle\Entity\Village $village = null)
    {
        $this->village = $village;

        return $this;
    }

    /**
     * Get village
     *
     * @return \GO\MainBundle\Entity\Village 
     */
    public function getVillage()
    {
        return $this->village;
    }

    /**
     * Set user
     *
     * @param \GO\UserBundle\Entity\User $user
     * @return Client
     */
    public function setUser(\GO\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GO\MainBundleEntity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set bloc
     *
     * @param \GO\MainBundle\Entity\Bloc $bloc
     * @return Client
     */
    public function setBloc(\GO\MainBundle\Entity\Bloc $bloc = null)
    {
        $this->bloc = $bloc;

        return $this;
    }

    /**
     * Get bloc
     *
     * @return \GO\MainBundle\Entity\Bloc 
     */
    public function getBloc()
    {
        return $this->bloc;
    }
    public function addReservation(\GO\CaravaneBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \GO\CaravaneBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\GO\CaravaneBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
    public function setUfr(\GO\MainBundle\Entity\Ufr $ufr=null)
    {
        $this->ufr = $ufr;

        return $this;
    }

    /**
     * Get ufr
     *
     * @return \GO\MainBundle\Entity\Ufr
     */
    public function getUfr()
    {
        return $this->ufr;
    }
    public function setSection(\GO\MainBundle\Entity\Section $sect=null)
    {
        $this->section = $sect;

        return $this;
    }

    /**
     * Get ufr
     *
     * @return GO\MainBundle\Entity\Section 
     */
    public function getSection()
    {
        return $this->section;
    }
    public function getPrenomAbrege()
    {
        if(str_word_count(trim($this->prenom),0)>1)
        {
        //$nom= str_replace(" ", ",", $this->prenom);
            $prenom_abrege="";     
            $prenoms= str_word_count(trim($this->prenom),1);
            foreach($prenoms as $prenom)
            {
               $prenom_abrege.= substr($prenom,0,1).'. ';
            }
        }else
        {
            return $this->prenom;
        }
        return trim($prenom_abrege);
    }
    public function getNomComplet()
    {
        return ucwords($this->prenom)." ".strtoupper($this->nom);
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return Client
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Client
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set lastActive
     *
     * @param \DateTime $lastActive
     *
     * @return Client
     */
    public function setLastActive($lastActive)
    {
        $this->lastActive = $lastActive;

        return $this;
    }

    /**
     * Get lastActive
     *
     * @return \DateTime
     */
    public function getLastActive()
    {
        return $this->lastActive;
    }
}
