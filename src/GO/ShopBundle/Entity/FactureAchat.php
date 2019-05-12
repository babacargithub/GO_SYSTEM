<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactureAchat
 *
 * @ORM\Table(name="factureachat")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\FactureAchatRepository")
 */
class FactureAchat extends FactureAbstract
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="frais_port", type="integer", nullable=true)
     */
    private $fraisTransport;
    /**
     * @var \GO\ShopBundle\Entity\Fournisseur
     *
     * @ORM\ManyToOne(targetEntity="\GO\ShopBundle\Entity\Fournisseur", inversedBy="factures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fournisseur", referencedColumnName="id",onDelete="NO ACTION")
     * })
     */
    private $fournisseur;

    /**
    * @ORM\OneToMany(targetEntity="GO\ShopBundle\Entity\Achat", mappedBy="facture", cascade={"persist"})
    */
    private $achats;



    /**
     * Set fournisseur
     *
     * @param \GO\ShopBundle\Entity\Fournisseur $fournisseur
     * @return FactureAchat
     */
    public function setFournisseur(\GO\ShopBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \GO\ShopBundle\Entity\Fournisseur 
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->achats = new \Doctrine\Common\Collections\ArrayCollection();
       
    }

    /**
     * Add achats
     *
     * @param \GO\ShopBundle\Entity\Achat $achats
     * @return FactureAchat
     */
    public function addAchat(\GO\ShopBundle\Entity\Achat $achats)
    {
        $achats->setFacture($this);
        $this->achats[] = $achats;

        return $this;
    }

    /**
     * Remove achats
     *
     * @param \GO\ShopBundle\Entity\Achat $achats
     */
    public function removeAchat(\GO\ShopBundle\Entity\Achat $achats)
    {
        $this->achats->removeElement($achats);
    }

    /**
     * Get achats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAchats()
    {
        return $this->achats;
    }

   
    //====================== renvoi le total de la facture
    public function getTotal()
    {
        $total=0;
        foreach($this->achats as $achat)
        {
            $tot=$achat->getQuantite()*$achat->getPrixUnit();
            $total=$total+$tot;
        }
        return $total;
    }

    /**
     * Set fraisTransport
     *
     * @param integer $fraisTransport
     *
     * @return FactureAchat
     */
    public function setFraisTransport($fraisTransport)
    {
        $this->fraisTransport = $fraisTransport;

        return $this;
    }

    /**
     * Get fraisTransport
     *
     * @return integer
     */
    public function getFraisTransport()
    {
        return $this->fraisTransport;
    }
}
