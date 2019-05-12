<?php

namespace GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DebitCredit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\DebitCreditRepository")
 */
class DebitCredit
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
     * @ORM\Column(name="compteDebit", type="integer")
     */
    private $compteDebit;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var integer
     *
     * @ORM\Column(name="compteCredit", type="integer")
     */
    private $compteCredit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set compteDebit
     *
     * @param integer $compteDebit
     * @return DebitCredit
     */
    public function setCompteDebit($compteDebit)
    {
        $this->compteDebit = $compteDebit;

        return $this;
    }

    /**
     * Get compteDebit
     *
     * @return integer 
     */
    public function getCompteDebit()
    {
        return $this->compteDebit;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return DebitCredit
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

    /**
     * Set compteCredit
     *
     * @param integer $compteCredit
     * @return DebitCredit
     */
    public function setCompteCredit($compteCredit)
    {
        $this->compteCredit = $compteCredit;

        return $this;
    }

    /**
     * Get compteCredit
     *
     * @return integer 
     */
    public function getCompteCredit()
    {
        return $this->compteCredit;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return DebitCredit
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
}
