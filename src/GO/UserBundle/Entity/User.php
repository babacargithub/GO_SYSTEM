<?php

namespace GO\UserBundle\Entity;



use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="username", columns={"username", "tel"}), @ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="password", columns={"password"}), @ORM\Index(name="active", columns={"active"}), @ORM\Index(name="village_gere", columns={"en_ligne_user"})})
 * @ORM\Entity(repositoryClass="GO\UserBundle\Entity\UserRepository")
 */
class User extends \FOS\UserBundle\Entity\User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
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
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=20, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="bigint", nullable=false)
     */
    private $tel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="en_ligne_user", type="boolean", nullable=true)
     */
    private $enLigneUser;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active=true;
    /**
     * @var string
     *
     * @ORM\Column(name="apps", type="string", nullable=true)
     */
    private $apps;

    
    /**
     * Set level
     *
     * @param integer $level
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
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
     * @return User
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
     * @return User
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
     * Set enLigneUser
     *
     * @param boolean $enLigneUser
     * @return User
     */
    public function setEnLigneUser($enLigneUser)
    {
        $this->enLigneUser = $enLigneUser;

        return $this;
    }

    /**
     * Get enLigneUser
     *
     * @return boolean 
     */
    public function getEnLigneUser()
    {
        return $this->enLigneUser;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
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
     * Set apps
     *
     * @param string $apps
     * @return User
     */
    public function setApps($apps)
    {
        $this->apps = $apps;

        return $this;
    }

    /**
     * Get apps
     *
     * @return string
     */
    public function getApps()
    {
        return $this->apps;
    }
    public function hasApp($app)
    {
        return false;
    }
    public function getNomComplet (){
        return (string) ucfirst($this->getPrenom()).' '.strtoupper($this->getNom());
    }
    public function getNomCompletHumanized (){
        return (string) $this->username."--".ucfirst($this->getPrenom()).' '.strtoupper($this->getNom());
    }
}
