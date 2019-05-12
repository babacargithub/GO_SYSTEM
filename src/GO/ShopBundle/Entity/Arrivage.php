<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Arrivage
 *
 * @ORM\Table(name="arrivage")
 * @ORM\Entity
 */
class Arrivage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="produit", type="integer", nullable=true)
     */
    private $produit;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_achat", type="integer", nullable=true)
     */
    private $prixAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_vente", type="text", nullable=true)
     */
    private $prixVente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set produit
     *
     * @param integer $produit
     * @return Arrivage
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return integer 
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Arrivage
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixAchat
     *
     * @param integer $prixAchat
     * @return Arrivage
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
     * @param string $prixVente
     * @return Arrivage
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return string 
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Arrivage
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
