<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** C'est cette Entité qui permet de garder trace des opérations de sortie ou d'entrée sur la caisse
 * A chaque sortie ou entrée, une opération de cette entité est crée. Elle permet aussi de connaitre les différents 
 * HistoCaisses effectués sur une caisse donnée, mais aussi de retrouver le  solde d'une caisse pour une date précise 
 * HistoCaisse
 *
 * @ORM\Table(name="historique_caisse")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\HistoCaisseRepository")
 */
class HistoCaisse extends BaseClassCaisse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** Type opération qui peut être une sortie ou une entrée 
     * @var int
     *
     * @ORM\Column(name="typeOp", type="integer", nullable=true)
     */
    private $typeOp;

    /** l'ancien solde de la caisse concernée avant opération
     * @var int
     *
     * @ORM\Column(name="ancienSolde", type="integer")
     */
    private $ancienSolde;

    /** le solde de la caisse concernée après opération 
     * @var int
     *
     * @ORM\Column(name="nouveauSolde", type="integer")
     */
    private $nouveauSolde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOp", type="datetime")
     */
    private $dateOp;
     /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /** Si c'est une sortie, on précise ici la sortie
     * @var \GO\CaisseBundle\Entity\Sortie
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Sortie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sortie", referencedColumnName="id",onDelete="NO ACTION", nullable=true)
     * })
     */
    private $sortie;

    /** si c'est une entrée, on précise ici l'entrée
      /*
     * @var \GO\CaisseBundle\Entity\Entree
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Entree")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entree", referencedColumnName="id",onDelete="NO ACTION", nullable=true)
     * })
     */
    private $entree;

     /**
     * @var int
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted=false;
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * Set typeOp
     *
     * @param integer $typeOp
     *
     * @return HistoCaisse
     */
    public function setTypeOp($typeOp)
    {
        $this->typeOp = $typeOp;

        return $this;
    }

    /**
     * Get typeOp
     *
     * @return int
     */
    public function getTypeOp()
    {
        return $this->typeOp;
    }

    /**
     * Set ancienSolde
     *
     * @param integer $ancienSolde
     *
     * @return HistoCaisse
     */
    public function setAncienSolde($ancienSolde)
    {
        $this->ancienSolde = $ancienSolde;

        return $this;
    }

    /**
     * Get ancienSolde
     *
     * @return int
     */
    public function getAncienSolde()
    {
        return $this->ancienSolde;
    }

    /**
     * Set nouveauSolde
     *
     * @param integer $nouveauSolde
     *
     * @return HistoCaisse
     */
    public function setNouveauSolde($nouveauSolde)
    {
        $this->nouveauSolde = $nouveauSolde;

        return $this;
    }

    /**
     * Get nouveauSolde
     *
     * @return int
     */
    public function getNouveauSolde()
    {
        return $this->nouveauSolde;
    }

    /**
     * Set dateOp
     *
     * @param \DateTime $dateOp
     *
     * @return HistoCaisse
     */
    public function setDateOp($dateOp)
    {
        $this->dateOp = $dateOp;

        return $this;
    }

    /**
     * Get dateOp
     *
     * @return \DateTime
     */
    public function getDateOp()
    {
        return $this->dateOp;
    }

    
    /**
     * Set montant
     *
     * @param integer $montant
     *
     * @return HistoCaisse
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return int
     */
    public function getMontant()
    {
        return $this->montant;
    }



    /**
     * Set sortie
     *
     * @param \GO\CaisseBundle\Entity\Sortie $sortie
     *
     * @return HistoCaisse
     */
    public function setSortie(\GO\CaisseBundle\Entity\Sortie $sortie = null)
    {
        $this->sortie = $sortie;

        return $this;
    }

    /**
     * Get sortie
     *
     * @return \GO\CaisseBundle\Entity\Sortie
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * Set entree
     *
     * @param \GO\CaisseBundle\Entity\Entree $entree
     *
     * @return HistoCaisse
     */
    public function setEntree(\GO\CaisseBundle\Entity\Entree $entree = null)
    {
        $this->entree = $entree;

        return $this;
    }

    /**
     * Get entree
     *
     * @return \GO\CaisseBundle\Entity\Entree
     */
    public function getEntree()
    {
        return $this->entree;
    }
    
    public function getOperation()
    {
        if(!is_null($this->sortie))
        {
            return $this->sortie;
        }
        if(!is_null($this->entree))
        {
            return $this->entree;
        }
        return null;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return HistoCaisse
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return HistoCaisse
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
