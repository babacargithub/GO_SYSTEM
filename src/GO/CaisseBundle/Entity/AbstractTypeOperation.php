<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractTypeOperation
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractTypeOperation
{
    const ENTREE_LIQUIDE=1;
    const SORTIE_LIQUIDE=2;
    const VERSEMENT_BANQUE_EMIS=3;
    const VIREMENT_BANQUE_EMIS=4;
    const VERSEMENT_BANQUE_RECU=5;
    const VIREMENT_BANQUE_RECU=6;
    const AUTRE_OPERATION=0;
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
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="categorie", type="integer", nullable=true)
     */
    private $categorie;


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
     * @return AbstractTypeOperation
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return AbstractTypeOperation
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
     * Set categorie
     *
     * @param integer $categorie
     *
     * @return AbstractTypeOperation
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return int
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    
    public function __toString() {
        return $this->getLibelle();
    }
}

