<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CandidatureRepository")
 */
class Candidature extends BaseClass{
    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dossier")
     * @ORM\JoinColumn(nullable=false)

     */
    private $dossier;

    /**
     * @var string
     *
     * @ORM\Column(name="formationDemandee", type="string", length=255)
     */
    private $formationDemandee;

    
    /**
     * @var \AppBundle\Entity\Niveau
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Niveau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveauDemande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="accepte", type="boolean", nullable=true)
     */
    private $accepte=false;

    /**
     * @var bool
     *
     * @ORM\Column(name="visaAccepte", type="boolean", nullable=true)
     */
    private $visaAccepte=false;

    /**
     * @var string
     *
     * @ORM\Column(name="villeCible", type="string", length=255, nullable=true)
     */
    private $villeCible;

    /**
     * @var string
     *
     * @ORM\Column(name="deuxiemeChoix", type="string", length=255, nullable=true)
     */
    private $deuxiemeChoix;

    /**
     * @var string
     *
     * @ORM\Column(name="troisiemeChoix", type="string", length=255, nullable=true)
     */
    private $troisiemeChoix;
    
    /**
     * @var \AppBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pays")
     * @ORM\JoinColumn(name="pays_demande", nullable=false)
     */
    private $paysDemande;
    /**
     * @var \AppBundle\Entity\Plateforme
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Plateforme")
     * @ORM\JoinColumn(name="plateforme", nullable=false)
     */
    private $plateforme;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set formationDemandee
     *
     * @param string $formationDemandee
     *
     * @return Candidature
     */
    public function setFormationDemandee($formationDemandee) {
        $this->formationDemandee = $formationDemandee;

        return $this;
    }

    /**
     * Get formationDemandee
     *
     * @return string
     */
    public function getFormationDemandee() {
        return $this->formationDemandee;
    }

    /**
     * Set niveauDemande
     *
     * @param string $niveauDemande
     *
     * @return Candidature
     */
    public function setNiveauDemande($niveauDemande) {
        $this->niveauDemande = $niveauDemande;

        return $this;
    }

    /**
     * Get niveauDemande
     *
     * @return string
     */
    public function getNiveauDemande() {
        return $this->niveauDemande;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Candidature
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
     * Set accepte
     *
     * @param boolean $accepte
     *
     * @return Candidature
     */
    public function setAccepte($accepte) {
        $this->accepte = $accepte;

        return $this;
    }

    /**
     * Get accepte
     *
     * @return bool
     */
    public function getAccepte() {
        return $this->accepte;
    }

    /**
     * Set visaAccepte
     *
     * @param boolean $visaAccepte
     *
     * @return Candidature
     */
    public function setVisaAccepte($visaAccepte) {
        $this->visaAccepte = $visaAccepte;

        return $this;
    }

    /**
     * Get visaAccepte
     *
     * @return bool
     */
    public function getVisaAccepte() {
        return $this->visaAccepte;
    }

    /**
     * Set vileCible
     *
     * @param string $vileCible
     *
     * @return Candidature
     */
    public function setVileCible($vileCible) {
        $this->vileCible = $vileCible;

        return $this;
    }

    /**
     * Get vileCible
     *
     * @return string
     */
    public function getVileCible() {
        return $this->vileCible;
    }

    /**
     * Set deuxiemeChoix
     *
     * @param string $deuxiemeChoix
     *
     * @return Candidature
     */
    public function setDeuxiemeChoix($deuxiemeChoix) {
        $this->deuxiemeChoix = $deuxiemeChoix;

        return $this;
    }

    /**
     * Get deuxiemeChoix
     *
     * @return string
     */
    public function getDeuxiemeChoix() {
        return $this->deuxiemeChoix;
    }

    /**
     * Set troisiemeChoix
     *
     * @param string $troisiemeChoix
     *
     * @return Candidature
     */
    public function setTroisiemeChoix($troisiemeChoix) {
        $this->troisiemeChoix = $troisiemeChoix;

        return $this;
    }

    /**
     * Get troisiemeChoix
     *
     * @return string
     */
    public function getTroisiemeChoix() {
        return $this->troisiemeChoix;
    }


    /**
     * Set villeCible
     *
     * @param string $villeCible
     *
     * @return Candidature
     */
    public function setVilleCible($villeCible)
    {
        $this->villeCible = $villeCible;

        return $this;
    }

    /**
     * Get villeCible
     *
     * @return string
     */
    public function getVilleCible()
    {
        return $this->villeCible;
    }

    /**
     * Set dossier
     *
     * @param \AppBundle\Entity\Dossier $dossier
     *
     * @return Candidature
     */
    public function setDossier(\AppBundle\Entity\Dossier $dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return \AppBundle\Entity\Dossier
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Set paysDemande
     *
     * @param \AppBundle\Entity\Pays $paysDemande
     *
     * @return Candidature
     */
    public function setPaysDemande(\AppBundle\Entity\Pays $paysDemande)
    {
        $this->paysDemande = $paysDemande;

        return $this;
    }

    /**
     * Get paysDemande
     *
     * @return \AppBundle\Entity\Pays
     */
    public function getPaysDemande()
    {
        return $this->paysDemande;
    }

    /**
     * Set plateforme
     *
     * @param \AppBundle\Entity\Plateforme $plateforme
     *
     * @return Candidature
     */
    public function setPlateforme(\AppBundle\Entity\Plateforme $plateforme)
    {
        $this->plateforme = $plateforme;

        return $this;
    }

    /**
     * Get plateforme
     *
     * @return \AppBundle\Entity\Plateforme
     */
    public function getPlateforme()
    {
        return $this->plateforme;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Candidature
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }
}
