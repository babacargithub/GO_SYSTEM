<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CreanceLiquide
 *
 * @ORM\Table(name="creance_liquide")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\CreanceLiquideRepository")
 */
class CreanceLiquide extends CreanceBaseClass
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
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;
  /**
     * @ORM\OneToMany(targetEntity="GO\ShopBundle\Entity\RembCreanceLiquide", mappedBy="creance")
     */
    private $remboursements;

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
     * Set montant
     *
     * @param integer $montant
     * @return CreanceLiquide
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }
    
    //===================FONCTIONS DIVERSES ============
    // renvoie le total de lacreance
    public function getTotal()
    {
        return  $this->montant;
    }
    //====================== renvoi le total de la somme déjà remboursé sur la créance
    public function getTotalRembourse()
    {
        $total=0;
        foreach($this->remboursements as $remb)
        {
            $total=$total+$remb->getMontant();
        }
        return $total;
    }
    //====================== renvoi le total de la somme restant à rembourser sur la créance
    public function getTotalRestant()
    {
        
        return $this->getTotal()-$this->getTotalRembourse();
    }

    /**
     * Add remboursements
     *
     * @param \GO\ShopBundle\Entity\RembCreanceLiquide $remboursements
     * @return CreanceLiquide
     */
    public function addRemboursement(\GO\ShopBundle\Entity\RembCreanceLiquide $remboursements)
    {
        $this->remboursements[] = $remboursements;

        return $this;
    }

    /**
     * Remove remboursements
     *
     * @param \GO\ShopBundle\Entity\RembCreanceLiquide $remboursements
     */
    public function removeRemboursement(\GO\ShopBundle\Entity\RembCreanceLiquide $remboursements)
    {
        $this->remboursements->removeElement($remboursements);
    }

    /**
     * Get remboursements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRemboursements()
    {
        return $this->remboursements;
    }
}
