<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GO\GOLibrary\Utils\LetterToNumber;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="type", columns={"type"})})
 * @ORM\Entity(repositoryClass="ProduitRepository")
 * @UniqueEntity(fields="nom", message="Un produit existe déjà avec ce nom.")
 */
class Produit
{
    const DEFAULT_CODE_BAR_LENGTH=14;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\Length(min=2)
     */
    private $nom;

   /**
    *
    * @ORM\ManyToOne(targetEntity="TypeProduit")
    * @ORM\JoinColumns({@ORM\JoinColumn(name="type", referencedColumnName="id", nullable=false)})
    */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_achat", type="integer", nullable=true)
     */
    private $prixAchat;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_vente", type="integer", nullable=true)
     */
    private $prixVente;

    /**
     * @var string
     *
     * @ORM\Column(name="descrip", type="string", length=255, nullable=true)
     */
    private $descrip;
    /**
     * @var string
     *
     * @ORM\Column(name="default_code_bar", type="string", length=30, nullable=true, unique=true)
     */
    private $defaultCodeBar;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="id",onDelete="NO ACTION", nullable=true)
     * })
     */
    private $categorie;
    /**
     * @var string
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif=true;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

public function __toString() {
        return $this->getNom();
    }


    /**
     * Set nom
     *
     * @param string $nom
     * @return Produit
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
     * Set prixAchat
     *
     * @param integer $prixAchat
     * @return Produit
     */
    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    /**
     * Get prixAchat
     *
     * @return integer 
     */
    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    /**
     * Set prixVente
     *
     * @param integer $prixVente
     * @return Produit
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return integer 
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set descrip
     *
     * @param string $descrip
     * @return Produit
     */
    public function setDescrip($descrip)
    {
        $this->descrip = $descrip;

        return $this;
    }

    /**
     * Get descrip
     *
     * @return string 
     */
    public function getDescrip()
    {
        return $this->descrip;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Produit
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
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
     * Set type
     *
     * @param TypeProduit $type
     * @return Produit
     */
    public function setType(TypeProduit $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return TypeProduit 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set categorie
     *
     * @param Categorie $categorie
     * @return Produit
     */
    public function setCategorie(Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Produit
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }
    public function generateDefaultCodeBar()
    {
        $idLength=\strlen($this->id);
        $length=self::DEFAULT_CODE_BAR_LENGTH-$idLength;
        $nom= LetterToNumber::remove_accents($this->nom);
        $shortenName= \substr($nom, 0, ($length/2));
        $this->defaultCodeBar=$this->id."".LetterToNumber::letterToNumber($shortenName);
         
         return $this;
    }
    
    public function getDefaultCodeBar() {
        return $this->defaultCodeBar;
    }


}
