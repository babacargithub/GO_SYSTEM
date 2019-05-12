<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractSortie
 *
 * @ORM\MappedSuperclass()
 */
class AbstractSortie extends BaseClass
{
    const SORTIE_LIQUIE=1;
    const SORTIE_NON_LIQUIE=2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    //Ce type permet de distinguer les sorties liquides des autres sorties 
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="string", length=255)
     */
    private $motif;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var \GO\CaisseBundle\Entity\TypeSortie
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\TypeSortie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_sortie", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $typeSortie;

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
     * Set montant
     *
     * @param integer $montant
     *
     * @return AbstractSortie
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AbstractSortie
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
     * Set motif
     *
     * @param string $motif
     *
     * @return AbstractSortie
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return AbstractSortie
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

   

    

    

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return AbstractSortie
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set typeSortie
     *
     * @param \GO\CaisseBundle\Entity\TypeSortie $typeSortie
     *
     * @return AbstractSortie
     */
    public function setTypeSortie(\GO\CaisseBundle\Entity\TypeSortie $typeSortie)
    {
        $this->typeSortie = $typeSortie;

        return $this;
    }

    /**
     * Get typeSortie
     *
     * @return \GO\CaisseBundle\Entity\TypeSortie
     */
    public function getTypeSortie()
    {
        return $this->typeSortie;
    }

    /**
     * Set caisse
     *
     * @param \GO\CaisseBundle\Entity\Caisse $caisse
     *
     * @return AbstractSortie
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
