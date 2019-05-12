<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;  


/**
 * Dossier
 *
 * @ORM\Table(name="dossier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DossierRepository")
 * @UniqueEntity("num", message="Ce candidat a déjà un dossier!")

 */
class Dossier extends BaseClass{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Candidat", inversedBy="dossier",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidat;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Exercice", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercice;

    /**
     * @var int
     *
     * @ORM\Column(name="num", type="integer", unique=true)
     */
    private $num;
    /**
     * @var int
     *
     * @ORM\Column(name="frais", type="integer", nullable=true)
     * @Assert\Type("integer")
     * @Assert\Length(min=3, minMessage="Montant invalide! Il est trop petit!")
     */
    private $frais;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean", nullable=true)
     */
    private $etat=true;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt=null;

    /**
     * @var bool
     *
     * @ORM\Column(name="canceled", type="boolean", nullable=true)
     */
    private $canceled=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="canceledAt", type="datetime", nullable=true)
     */
    private $canceledAt;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Candidature", mappedBy="dossier", cascade={"persist"})
     */
    private $candidatures;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Paiement", mappedBy="dossier", cascade={"persist"})
     */
    private $paiements;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return Dossier
     */
    public function setNum($num) {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return int
     */
    public function getNum() {
        return $this->num;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Dossier
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Dossier
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return bool
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Dossier
     */
    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Dossier
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return bool
     */
    public function getDeleted() {
        return $this->deleted;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Dossier
     */
    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * Set canceled
     *
     * @param boolean $canceled
     *
     * @return Dossier
     */
    public function setCanceled($canceled) {
        $this->canceled = $canceled;

        return $this;
    }

    /**
     * Get canceled
     *
     * @return bool
     */
    public function getCanceled() {
        return $this->canceled;
    }

    /**
     * Set canceledAt
     *
     * @param \DateTime $canceledAt
     *
     * @return Dossier
     */
    public function setCanceledAt($canceledAt) {
        $this->canceledAt = $canceledAt;

        return $this;
    }

    /**
     * Get canceledAt
     *
     * @return \DateTime
     */
    public function getCanceledAt() {
        return $this->canceledAt;
    }


    /**
     * Set candidat
     *
     * @param \AppBundle\Entity\Candidat $candidat
     *
     * @return Dossier
     */
    public function setCandidat(\AppBundle\Entity\Candidat $candidat)
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return \AppBundle\Entity\Candidat
     */
    public function getCandidat()
    {
        return $this->candidat;
    }
     public function __toString() {
        return 'Dossier de '.$this->candidat->getPrenom().' '.$this->candidat->getNom();
    }

    /**
     * Set exercice
     *
     * @param \AppBundle\Entity\Exercice $exercice
     *
     * @return Dossier
     */
    public function setExercice(\AppBundle\Entity\Exercice $exercice)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return \AppBundle\Entity\Exercice
     */
    public function getExercice()
    {
        return $this->exercice;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->candidatures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Add candidature
     *
     * @param \AppBundle\Entity\Candidature $candidature
     *
     * @return Dossier
     */
    public function addCandidature(\AppBundle\Entity\Candidature $candidature)
    {
        $this->candidatures[] = $candidature;

        return $this;
    }

    /**
     * Remove candidature
     *
     * @param \AppBundle\Entity\Candidature $candidature
     */
    public function removeCandidature(\AppBundle\Entity\Candidature $candidature)
    {
        $this->candidatures->removeElement($candidature);
    }

    /**
     * Get candidatures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidatures()
    {
        return $this->candidatures;
    }
    public function generateNum()
    {
        $sexe='';
        if($this->candidat->getSexe()=="M")
        $sexe=1;
        elseif($this->candidat->getSexe()=="F")
            $sexe=2;
        else
            return exit('Erreur survenue! Sexe du candidat inconnu!');
       
            
        
        $id= $this->candidat->getId();
        //ajoute des zeros à la fin des id dont la longeur fait moins de 4 caractères 
        for($i=0;strlen($id)<4;$i++)
        {
            $id=$id.'0';
        }
        $num=$sexe.Date('y').''.$id;
        $this->setNum(intval($num));
    }

    /**
     * Add paiement
     *
     * @param \AppBundle\Entity\Paiement $paiement
     *
     * @return Dossier
     */
    public function addPaiement(\AppBundle\Entity\Paiement $paiement)
    {
        $this->paiements[] = $paiement;

        return $this;
    }

    /**
     * Remove paiement
     *
     * @param \AppBundle\Entity\Paiement $paiement
     */
    public function removePaiement(\AppBundle\Entity\Paiement $paiement)
    {
        $this->paiements->removeElement($paiement);
    }

    /**
     * Get paiements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaiements()
    {
        return $this->paiements;
    }
    public function getTotalPaiements()
    {
        $total=0;
        foreach($this->paiements as $paiement)
        {
            $total=$total+$paiement->getMontant();
        }
        return intval( $total);
    }

    /**
     * Set frais
     *
     * @param integer $frais
     *
     * @return Dossier
     */
    public function setFrais($frais)
    {
        $this->frais = $frais;

        return $this;
    }

    /**
     * Get frais
     *
     * @return integer
     */
    public function getFrais()
    {
        return $this->frais;
    }
}
