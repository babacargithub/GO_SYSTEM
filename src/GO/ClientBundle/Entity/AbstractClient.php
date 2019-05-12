<?php

namespace  GO\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Client
 *
 * @ORM\MappedSuperclass()
 * @UniqueEntity(fields={"tel"}, message="Ce numéro téléphone est déjà utilisé par un autre client!")
 * @UniqueEntity(
 *      fields={"email"}, 
 *      ignoreNull=true,
 *      message="Cet email  est déjà utilisé par un autre client!"
 * )
 */
class AbstractClient
{
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=false)
     * @Assert\Length(min=2, max=30, minMessage="Prénom trop court", maxMessage="Prénom trop long")
     * @Assert\Type(type="alpha", message="Le prénom ne doit pas contenir de chiffres")
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     * @Assert\Length(min=2, max=20, minMessage="Nom trop court", maxMessage="Nom trop long")
     * @Assert\Type(type="alpha", message="Le nom ne doit pas contenir de chiffres")
     * @Assert\NotBlank()
       */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", unique=true, nullable=true)
     * @Assert\Email();
     */
    private $email;
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     * @Assert\Choice(choices={"F", "M"}, message="Choisissez un type de sexe valide. Type de sexe choisi invalide!")
     */
     
    private $sexe;
    /**
     * @var \GO\ClientBundle\Entity\CategorieClient
     *
     * @ORM\ManyToOne(targetEntity="GO\ClientBundle\Entity\CategorieClient")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="categorie", referencedColumnName="id", nullable=false) })
     **/
    private $categorie;
    /**
     * @var integer
     *
     * @ORM\Column(name="disabled", type="boolean", nullable=false)
     */
    private $disabled=false;
    /**
     * @var integer
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private $deleated=false;
    /**
     * @var integer
     *
     * @ORM\Column(name="deleated_at", type="datetime", nullable=true)
     */
    private $deleatedAt;
    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active=true;
    /**
     * @var integer
     *
     * @ORM\Column(name="last_active", type="datetime", nullable=true)
     */
    private $lastActive;

    

    //==========Custom functions
 public function getPrenomAbrege()
    {
        if(str_word_count(trim($this->prenom),0)>1)
        {
            $prenom_abrege="";  
        //$nom= str_replace(" ", ",", $this->prenom);
               
            $prenoms= str_word_count(trim($this->prenom),1);
            foreach($prenoms as $prenom)
            {
               $prenom_abrege.= substr($prenom,0,1).'. ';
            } 
            return trim($prenom_abrege);
        }else
        {
            return $this->prenom;
        }
       
    }
    public function getNomComplet()
    {
        return ucwords($this->prenom)." ".strtoupper($this->nom);
    }

    public function getShortFirstName()
    {
        return $this->getPrenomAbrege();
    }
    public function getFullName()
    {
        return $this->getNomComplet();
    }
/**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return AbstractClient
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
     *
     * @return AbstractClient
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
//=======for compatibility reasons//
    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return AbstractClient
     */
    public function setFirstName($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return AbstractClient
     */
    public function setLastName($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->nom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AbstractClient
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return AbstractClient
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
     *
     * @return AbstractClient
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AbstractClient
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
     * Set sexe
     *
     * @param string $sexe
     *
     * @return AbstractClient
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
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return AbstractClient
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
     * Set deleated
     *
     * @param boolean $deleated
     *
     * @return AbstractClient
     */
    public function setDeleated($deleated)
    {
        $this->deleated = $deleated;

        return $this;
    }

    /**
     * Get deleated
     *
     * @return boolean
     */
    public function getDeleated()
    {
        return $this->deleated;
    }

    /**
     * Set deleatedAt
     *
     * @param \DateTime $deleatedAt
     *
     * @return AbstractClient
     */
    public function setDeleatedAt($deleatedAt)
    {
        $this->deleatedAt = $deleatedAt;

        return $this;
    }

    /**
     * Get deleatedAt
     *
     * @return \DateTime
     */
    public function getDeleatedAt()
    {
        return $this->deleatedAt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return AbstractClient
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
     * @return AbstractClient
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

    

    /**
     * Set categorie
     *
     * @param \GO\ClientBundle\Entity\CategorieClient $categorie
     *
     * @return AbstractClient
     */
    public function setCategorie(\GO\ClientBundle\Entity\CategorieClient $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \GO\ClientBundle\Entity\CategorieClient
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
