<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\CategorieRepository")
 */
class Categorie
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var string
     *@ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\TypeProduit")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="type_produit", referencedColumnName="id", onDelete="CASCADE", nullable=true)})
     */
    private $typeProduit;



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
     * Set nom
     *
     * @param string $nom
     * @return Categorie
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
     * Set typeProduit
     *
     * @param \GO\ShopBundle\Entity\TypeProduit $typeProduit
     * @return Categorie
     */
    public function setTypeProduit(\GO\ShopBundle\Entity\TypeProduit $typeProduit = null)
    {
        $this->typeProduit = $typeProduit;

        return $this;
    }

    /**
     * Get typeProduit
     *
     * @return \GO\ShopBundle\Entity\TypeProduit 
     */
    public function getTypeProduit()
    {
        return $this->typeProduit;
    }
}
