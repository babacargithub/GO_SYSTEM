<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompteBanque
 *
 * @ORM\Table(name="compte_banque")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\CompteBanqueRepository")
 */
class CompteBanque
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false, unique=true)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="numCompte", type="bigint", unique=true)
     */
    private $numCompte;

    /**
     * @var string
     *
     * @ORM\Column(name="banque", type="string", length=100)
     */
    private $banque;

    /**
     * @var int
     *
     * @ORM\Column(name="solde", type="integer")
     */
    private $solde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastOp", type="datetime", nullable=true)
     */
    private $lastOp;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return CompteBanque
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
     * Set numCompte
     *
     * @param integer $numCompte
     *
     * @return CompteBanque
     */
    public function setNumCompte($numCompte)
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    /**
     * Get numCompte
     *
     * @return int
     */
    public function getNumCompte()
    {
        return $this->numCompte;
    }

    /**
     * Set banque
     *
     * @param string $banque
     *
     * @return CompteBanque
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return string
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set solde
     *
     * @param integer $solde
     *
     * @return CompteBanque
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get solde
     *
     * @return int
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set lastOp
     *
     * @param \DateTime $lastOp
     *
     * @return CompteBanque
     */
    public function setLastOp($lastOp)
    {
        $this->lastOp = $lastOp;

        return $this;
    }

    /**
     * Get lastOp
     *
     * @return \DateTime
     */
    public function getLastOp()
    {
        return $this->lastOp;
    }
    public function __toString() {
        return $this->libelle;
    }
    
    public function augmenterSolde($montant)
    {
        $this->solde= $this->solde+intval($montant);
    }
    public function diminuerSolde($montant)
    {
        $this->solde= $this->solde-intval($montant);
    }
}

