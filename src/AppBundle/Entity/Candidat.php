<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Candidat
 *
 * @ORM\Table(name="candidat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CandidatRepository")
  *@UniqueEntity("email",message="Email existe déjà")
  *@UniqueEntity("tel",message="Téléphone appartient déjà à un candidat!")
 */
class Candidat extends BaseClass
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
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Le prénom doit être contenir 3 charactères minimum",
     *      maxMessage = "Prénom Trop long!")
     * @Assert\NotNull(message="Le Nom ne peut pas être vide!")
     * @Assert\Type("string")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "nom doit être contenir 2 charactères minimum",
     *      maxMessage = "Prénom Trop long!" )
     * @Assert\NotNull(message="Le nom ne peut pas être vide!")
     * @Assert\Type("string")
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", unique=true)
     * @Assert\Type("integer")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true, unique=true)
     * @Assert\Type("string")
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaiss", type="date", nullable=true)
     */
    private $dateNaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaiss", type="string", length=100, nullable=true)
     */
    private $lieuNaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="numCni", type="bigint", length=18, nullable=true, unique=true)
     */
    private $numCni;

    /**
     * @var string
     *
     * @ORM\Column(name="remarques", type="text", nullable=true)
     */
    private $remarques;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @var \AppBundle\Entity\Niveau
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Niveau")
     * @ORM\JoinColumn(name="niveau_acuel", nullable=false)
     */
    private $niveauActuel;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", nullable=true)
     */
    private $villeActuel;
    /**
     * @var integer
     *
     * @ORM\Column(name="annee_bac", type="integer", length=4, nullable=true)
     */
    private $anneeBac;
    /**
     * @var string
     *
     * @ORM\Column(name="etabliss", type="string", nullable=true)
     */
    private $etablissActuel;
    /**
     * @var string
     *
     * @ORM\Column(name="formation_actuel", type="string", length=256, nullable=true)
     */
    private $formationActuel;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=1, nullable=true)
     */
    private $serie;
     /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Dossier", mappedBy="candidat",cascade={"persist"})
     */
    private $dossier;

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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Candidat
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Candidat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return Candidat
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Candidat
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateNaiss
     *
     * @param \DateTime $dateNaiss
     *
     * @return Candidat
     */
    public function setDateNaiss($dateNaiss)
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    /**
     * Get dateNaiss
     *
     * @return \DateTime
     */
    public function getDateNaiss()
    {
        return $this->dateNaiss;
    }

    /**
     * Set lieuNaiss
     *
     * @param string $lieuNaiss
     *
     * @return Candidat
     */
    public function setLieuNaiss($lieuNaiss)
    {
        $this->lieuNaiss = $lieuNaiss;

        return $this;
    }

    /**
     * Get lieuNaiss
     *
     * @return string
     */
    public function getLieuNaiss()
    {
        return $this->lieuNaiss;
    }

    /**
     * Set numCni
     *
     * @param string $numCni
     *
     * @return Candidat
     */
    public function setNumCni($numCni)
    {
        $this->numCni = $numCni;

        return $this;
    }

    /**
     * Get numCni
     *
     * @return bigint
     */
    public function getNumCni()
    {
        return $this->numCni;
    }

    /**
     * Set remarques
     *
     * @param string $remarques
     *
     * @return Candidat
     */
    public function setRemarques($remarques)
    {
        $this->remarques = $remarques;

        return $this;
    }

    /**
     * Get remarques
     *
     * @return string
     */
    public function getRemarques()
    {
        return $this->remarques;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Candidat
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set niveauActuel
     *
     * @param string $niveauActuel
     *
     * @return Candidat
     */
    public function setNiveauActuel($niveauActuel)
    {
        $this->niveauActuel = $niveauActuel;

        return $this;
    }

    /**
     * Get niveauActuel
     *
     * @return string
     */
    public function getNiveauActuel()
    {
        return $this->niveauActuel;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return Candidat
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set villeActuel
     *
     * @param string $villeActuel
     *
     * @return Candidat
     */
    public function setVilleActuel($villeActuel)
    {
        $this->villeActuel = $villeActuel;

        return $this;
    }

    /**
     * Get villeActuel
     *
     * @return string
     */
    public function getVilleActuel()
    {
        return $this->villeActuel;
    }

    /**
     * Set anneeBac
     *
     * @param integer $anneeBac
     *
     * @return Candidat
     */
    public function setAnneeBac($anneeBac)
    {
        $this->anneeBac = $anneeBac;

        return $this;
    }

    /**
     * Get anneeBac
     *
     * @return integer
     */
    public function getAnneeBac()
    {
        return $this->anneeBac;
    }

    /**
     * Set etablissActuel
     *
     * @param string $etablissActuel
     *
     * @return Candidat
     */
    public function setEtablissActuel($etablissActuel)
    {
        $this->etablissActuel = $etablissActuel;

        return $this;
    }

    /**
     * Get etablissActuel
     *
     * @return string
     */
    public function getEtablissActuel()
    {
        return $this->etablissActuel;
    }

    /**
     * Set formationActuel
     *
     * @param \AppBundle\Entity\Formation $formationActuel
     *
     * @return Candidat
     */
    public function setFormationActuel($formationActuel = null)
    {
        $this->formationActuel = $formationActuel;

        return $this;
    }

    /**
     * Get formationActuel
     *
     * @return string
     */
    public function getFormationActuel()
    {
        return $this->formationActuel;
    }
     public function __toString() {
        return (string) ucfirst($this->getPrenom()).' '.strtoupper($this->getNom());
    }

    /**
     * Set dossier
     *
     * @param \AppBundle\Entity\Candidat $dossier
     *
     * @return Candidat
     */
    public function setDossier(\AppBundle\Entity\Candidat $dossier = null)
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
}
