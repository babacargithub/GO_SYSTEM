<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpBanque
 *
 * @ORM\Table(name="op_banque")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\OpBanqueRepository")
 */
class OpBanque extends BaseClassCaisse
{
    const VERSEMENT=1;
    const RETRAIT=2;
    const VIREMENT_EMIS=3;
    const VIREMENT_RECU=4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \GO\Caisse\Entity\CompteBanque
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\CompteBanque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="compte", referencedColumnName="id",nullable=false)
     * })
     */
    private $compte;

    //Il s'agit des quatres type d'opérations bancaires possibles (Versement Recu, Emis, Virement Reçu, Emis 
     /**
     * @var string
     *
     * @ORM\Column(name="typeOp", type="integer")
     */
    private $typeOp;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="justif", type="string", length=255)
     */
    private $justif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;



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
     * @param string $typeOp
     *
     * @return OpBanque
     */
    public function setTypeOp($typeOp)
    {
        $this->typeOp = $typeOp;

        return $this;
    }

    /**
     * Get typeOp
     *
     * @return integer
     */
    public function getTypeOp()
    {
        return $this->typeOp;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     *
     * @return OpBanque
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
     * Set justif
     *
     * @param string $justif
     *
     * @return OpBanque
     */
    public function setJustif($justif)
    {
        $this->justif = $justif;

        return $this;
    }

    /**
     * Get justif
     *
     * @return string
     */
    public function getJustif()
    {
        return $this->justif;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return OpBanque
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
     * Set compte
     *
     * @param \GO\CaisseBundle\Entity\CompteBanque $compte
     *
     * @return OpBanque
     */
    public function setCompte(\GO\CaisseBundle\Entity\CompteBanque $compte)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return \GO\CaisseBundle\Entity\CompteBanque
     */
    public function getCompte()
    {
        return $this->compte;
    }
}
