<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactureAchat
 *
 * @ORM\Table(name="facturevente")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\FactureVenteRepository")
 */
class FactureVente extends FactureAbstract
{
    /**
     * @var \GO\ShopBundle\Entity\ClientRevendeur
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\ClientRevendeur", inversedBy="factures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id",onDelete="NO ACTION", nullable=false)
     * })
     */
    private $client;


/**
    * @ORM\OneToMany(targetEntity="GO\ShopBundle\Entity\Vente", mappedBy="facture", cascade={"persist"}, fetch="EXTRA_LAZY")
    */
    private $ventes;

/**
     * Get ventes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVentes()
    {
        return $this->ventes;
    }
    /**
     * Set client
     *
     * @param \GO\ShopBundle\Entity\ClientReveneur $client
     * @return FactureVente
     */
    public function setClient(\GO\ShopBundle\Entity\ClientRevendeur $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \GO\ShopBundle\Entity\ClientRevendeur 
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ventes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ventes
     *
     * @param \GO\ShopBundle\Entity\Vente $ventes
     * @return FactureVente
     */
    public function addVente(\GO\ShopBundle\Entity\Vente $ventes)
    {
        $this->ventes[] = $ventes;

        return $this;
    }

    /**
     * Remove ventes
     *
     * @param \GO\ShopBundle\Entity\Vente $ventes
     */
    public function removeVente(\GO\ShopBundle\Entity\Vente $ventes)
    {
        $this->ventes->removeElement($ventes);
    }

  //====================== renvoi le total de la facture
    public function getTotal()
    {
        $total=0;
        foreach($this->ventes as $vente)
        {
            $tot=$vente->getQuantite()*$vente->getPrixUnit();
            $total=$total+$tot;
        }
        return (int) $total;
    }
     //====================== renvoi le total de bénéfice généré par la vente de la facture
    public function getBenefice()
    {
        $total=0;
        foreach($this->ventes as $vente)
        {
            $total=$total+$vente->getBenefice();
        }
        return (int) $total;
    }
}
