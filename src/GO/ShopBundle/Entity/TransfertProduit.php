<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TransfertProduit
 *
 * @ORM\Table(name="transfert_produit")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\TransfertProduitRepository")
 */
class TransfertProduit extends BaseClass
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
     * @var \GO\ShopBundle\Entity\Shop
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Shop")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinataire", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $destinataire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;
    /**
     * @var boolean
     *
     * @ORM\Column(name="paye", type="boolean")
     */
    private $paye;
    
    /**
    * @ORM\OneToMany(targetEntity="GO\ShopBundle\Entity\ProduitTransfere", mappedBy="transfertProduit", cascade={"persist"})
    */
private $produitTransferes;

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
     * Set date
     *
     * @param \DateTime $date
     * @return TransfertProduit
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
     * Set validated
     *
     * @param boolean $validated
     * @return TransfertProduit
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }
    /**
     * Get validated
     *
     * @return boolean 
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * Set destinataire
     *
     * @param \GO\ShopBundle\Entity\Shop $destinataire
     * @return TransfertProduit
     */
    public function setDestinataire(\GO\ShopBundle\Entity\Shop $destinataire)
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    /**
     * Get destinataire
     *
     * @return \GO\ShopBundle\Entity\Shop 
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * Set paye
     *
     * @param boolean $paye
     * @return TransfertProduit
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
     * Constructor
     */
    public function __construct()
    {
        $this->produitTransferes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add produitTransferes
     *
     * @param \GO\ShopBundle\Entity\ProduitTransfere $produitTransferes
     * @return TransfertProduit
     */
    public function addProduitTransfere(\GO\ShopBundle\Entity\ProduitTransfere  $produitTransferes)
    {
        $this->produitTransferes[] = $produitTransferes;

        return $this;
    }

    /**
     * Remove produitTransferes
     *
     * @param \GO\ShopBundle\Entity\ProduitTransfere  $produitTransferes
     */
    public function removeProduitTransfere(\GO\ShopBundle\Entity\ProduitTransfere  $produitTransferes)
    {
        $this->produitTransferes->removeElement($produitTransferes);
    }

    /**
     * Get produitTransferes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduitTransferes()
    {
        return $this->produitTransferes;
    }
    //====================== renvoi le total de la facture du transfert
    public function getTotal()
    {
        $total=0;
        foreach($this->produitTransferes as $produitTransfere)
        {
            $tot=$produitTransfere->getQuantite()*$produitTransfere->getProduit()->getPrixAchat();
            $total=$total+$tot;
        }
        return $total;
    }
}
