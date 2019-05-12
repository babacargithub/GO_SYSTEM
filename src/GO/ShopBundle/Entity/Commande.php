<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="Fk_id_produit", columns={"id_produit"}), @ORM\Index(name="fk_client", columns={"id_client"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=true)
     */
    private $idProduit;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_model", type="integer", nullable=true)
     */
    private $idModel;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="datetime", nullable=true)
     */
    private $dateCommande;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paye", type="boolean", nullable=true)
     */
    private $paye;

    /**
     * @var boolean
     *
     * @ORM\Column(name="livre", type="boolean", nullable=true)
     */
    private $livre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_commande", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;



    /**
     * Set idProduit
     *
     * @param integer $idProduit
     * @return Commande
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    /**
     * Get idProduit
     *
     * @return integer 
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * Set idModel
     *
     * @param integer $idModel
     * @return Commande
     */
    public function setIdModel($idModel)
    {
        $this->idModel = $idModel;

        return $this;
    }

    /**
     * Get idModel
     *
     * @return integer 
     */
    public function getIdModel()
    {
        return $this->idModel;
    }

    /**
     * Set idClient
     *
     * @param integer $idClient
     * @return Commande
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return integer 
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set dateCommande
     *
     * @param \DateTime $dateCommande
     * @return Commande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * Get dateCommande
     *
     * @return \DateTime 
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Set paye
     *
     * @param boolean $paye
     * @return Commande
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;

        return $this;
    }

    /**
     * Get paye
     *
     * @return boolean 
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * Set livre
     *
     * @param boolean $livre
     * @return Commande
     */
    public function setLivre($livre)
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * Get livre
     *
     * @return boolean 
     */
    public function getLivre()
    {
        return $this->livre;
    }

    /**
     * Get idCommande
     *
     * @return integer 
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }
}
