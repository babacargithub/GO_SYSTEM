<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Repository\MaterielRepository")
 */
class Materiel
{
    /**
     * @var int
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
     * @var int
     *
     * @ORM\Column(name="prixAchat", type="integer")
     */
    private $prixAchat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAchat", type="datetime")
     */
    private $dateAchat;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var int
     *
     * @ORM\Column(name="valeurActuel", type="integer", nullable=true)
     */
    private $valeurActuel;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Materiel
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
     *
     * @return Materiel
     */
    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    /**
     * Get prixAchat
     *
     * @return int
     */
    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    /**
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     *
     * @return Materiel
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Materiel
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set valeurActuel
     *
     * @param integer $valeurActuel
     *
     * @return Materiel
     */
    public function setValeurActuel($valeurActuel)
    {
        $this->valeurActuel = $valeurActuel;

        return $this;
    }

    /**
     * Get valeurActuel
     *
     * @return int
     */
    public function getValeurActuel()
    {
        return $this->valeurActuel;
    }
}

