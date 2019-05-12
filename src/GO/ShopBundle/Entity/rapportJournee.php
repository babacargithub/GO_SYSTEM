<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * rapportJournee
 *
 * @ORM\Table(name="rapport_journee")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\rapportJourneeRepository")
 */
class rapportJournee extends BaseClass
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
     * @ORM\Column(name="wari", type="integer")
     */
    private $wari;

    /**
     * @var integer
     *
     * @ORM\Column(name="om", type="integer")
     */
    private $om;

    /**
     * @var integer
     *
     * @ORM\Column(name="caisse", type="integer")
     */
    private $caisse;

    /**
     * @var integer
     *
     * @ORM\Column(name="sortie", type="integer")
     */
    private $sortie;

    /**
     * @var integer
     *
     * @ORM\Column(name="entree", type="integer")
     */
    private $entree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOp", type="datetime")
     */
    private $dateOp;

    /**
     * @var integer
     *
     * @ORM\Column(name="mar", type="integer")
     */
    private $mar;

    /**
     * @var integer
     *
     * @ORM\Column(name="mrendu", type="integer")
     */
    private $mrendu;

    /**
     * @var integer
     *
     * @ORM\Column(name="marecup", type="integer")
     */
    private $marecup;


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
     * Set wari
     *
     * @param integer $wari
     * @return rapportJournee
     */
    public function setWari($wari)
    {
        $this->wari = $wari;

        return $this;
    }

    /**
     * Get wari
     *
     * @return integer 
     */
    public function getWari()
    {
        return $this->wari;
    }

    /**
     * Set om
     *
     * @param integer $om
     * @return rapportJournee
     */
    public function setOm($om)
    {
        $this->om = $om;

        return $this;
    }

    /**
     * Get om
     *
     * @return integer 
     */
    public function getOm()
    {
        return $this->om;
    }

    /**
     * Set caisse
     *
     * @param integer $caisse
     * @return rapportJournee
     */
    public function setCaisse($caisse)
    {
        $this->caisse = $caisse;

        return $this;
    }

    /**
     * Get caisse
     *
     * @return integer 
     */
    public function getCaisse()
    {
        return $this->caisse;
    }

    /**
     * Set sortie
     *
     * @param integer $sortie
     * @return rapportJournee
     */
    public function setSortie($sortie)
    {
        $this->sortie = $sortie;

        return $this;
    }

    /**
     * Get sortie
     *
     * @return integer 
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * Set entree
     *
     * @param integer $entree
     * @return rapportJournee
     */
    public function setEntree($entree)
    {
        $this->entree = $entree;

        return $this;
    }

    /**
     * Get entree
     *
     * @return integer 
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return rapportJournee
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
     * Set dateOp
     *
     * @param \DateTime $dateOp
     * @return rapportJournee
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
     * Set mar
     *
     * @param integer $mar
     * @return rapportJournee
     */
    public function setMar($mar)
    {
        $this->mar = $mar;

        return $this;
    }

    /**
     * Get mar
     *
     * @return integer 
     */
    public function getMar()
    {
        return $this->mar;
    }

    /**
     * Set mrendu
     *
     * @param integer $mrendu
     * @return rapportJournee
     */
    public function setMrendu($mrendu)
    {
        $this->mrendu = $mrendu;

        return $this;
    }

    /**
     * Get mrendu
     *
     * @return integer 
     */
    public function getMrendu()
    {
        return $this->mrendu;
    }

    /**
     * Set marecup
     *
     * @param integer $marecup
     * @return rapportJournee
     */
    public function setMarecup($marecup)
    {
        $this->marecup = $marecup;

        return $this;
    }

    /**
     * Get marecup
     *
     * @return integer 
     */
    public function getMarecup()
    {
        return $this->marecup;
    }
}
