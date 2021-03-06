<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractEntree
 *
 * @ORM\MappedSuperclass()
 */
class AbstractEntree
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var \GO\CaisseBundle\Entity\TypeEntree
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\TypeEntree")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_entree", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $typeEntree;

   /**
     * @var \GO\CaisseBundle\Entity\Caisse
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Caisse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caisse", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $caisse;


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
     * @return AbstractEntree
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AbstractEntree
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
     * Set montant
     *
     * @param integer $montant
     *
     * @return AbstractEntree
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return AbstractEntree
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    
     public function __toString() {
        return $this->getLibelle();
    }

    /**
     * Set typeEntree
     *
     * @param \GO\CaisseBundle\Entity\TypeEntree $typeEntree
     *
     * @return AbstractEntree
     */
    public function setTypeEntree(\GO\CaisseBundle\Entity\TypeEntree $typeEntree)
    {
        $this->typeEntree = $typeEntree;

        return $this;
    }

    /**
     * Get typeEntree
     *
     * @return \GO\CaisseBundle\Entity\TypeEntree
     */
    public function getTypeEntree()
    {
        return $this->typeEntree;
    }

    /**
     * Set caisse
     *
     * @param \GO\CaisseBundle\Entity\Caisse $caisse
     *
     * @return AbstractEntree
     */
    public function setCaisse(\GO\CaisseBundle\Entity\Caisse $caisse)
    {
        $this->caisse = $caisse;

        return $this;
    }

    /**
     * Get caisse
     *
     * @return \GO\CaisseBundle\Entity\Caisse
     */
    public function getCaisse()
    {
        return $this->caisse;
    }
}
