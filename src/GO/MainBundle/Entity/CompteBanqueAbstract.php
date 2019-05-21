<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * compteBanque
 *
 * @ORM\Table(name="go_main_compte_banque")
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\compteBanqueRepository")
 */
class CompteBanqueAbstract
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
     * @var integer
     *
     * @ORM\Column(name="numCompte", type="bigint")
     */
    private $numCompte;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=100)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="solde", type="integer")
     */
    private $solde;

    /**
     * @var integer
     *
     * @ORM\Column(name="banque", type="integer")
     */
    private $banque;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDerniereOp", type="datetime")
     */
    private $dateDerniereOp;


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
     * Set numCompte
     *
     * @param integer $numCompte
     * @return compteBanque
     */
    public function setNumCompte($numCompte)
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    /**
     * Get numCompte
     *
     * @return integer 
     */
    public function getNumCompte()
    {
        return $this->numCompte;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return compteBanque
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
     * Set solde
     *
     * @param integer $solde
     * @return compteBanque
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get solde
     *
     * @return integer 
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set banque
     *
     * @param integer $banque
     * @return compteBanque
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return integer 
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set dateDerniereOp
     *
     * @param \DateTime $dateDerniereOp
     * @return compteBanque
     */
    public function setDateDerniereOp($dateDerniereOp)
    {
        $this->dateDerniereOp = $dateDerniereOp;

        return $this;
    }

    /**
     * Get dateDerniereOp
     *
     * @return \DateTime 
     */
    public function getDateDerniereOp()
    {
        return $this->dateDerniereOp;
    }
}
