<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Desabonnement
 *
 * @ORM\Table(name="desabonnement", indexes={@ORM\Index(name="id_client_abnmnt", columns={"client"}), @ORM\Index(name="type_abnmnt", columns={"type_abnmnt"}), @ORM\Index(name="date_desabnmnt", columns={"date_desabnmnt"})})
 * @ORM\Entity
 */
class Desabonnement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="client", type="integer", nullable=false)
     */
    private $client;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_abnmnt", type="date", nullable=true)
     */
    private $dateAbnmnt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_exp_abnmnt", type="date", nullable=true)
     */
    private $dateExpAbnmnt;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_abnmnt", type="integer", nullable=false)
     */
    private $typeAbnmnt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etat_abnmnt", type="boolean", nullable=false)
     */
    private $etatAbnmnt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_desabnmnt", type="datetime", nullable=true)
     */
    private $dateDesabnmnt;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="motif", type="integer", nullable=true)
     */
    private $motif;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set client
     *
     * @param integer $client
     * @return Desabonnement
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return integer 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set dateAbnmnt
     *
     * @param \DateTime $dateAbnmnt
     * @return Desabonnement
     */
    public function setDateAbnmnt($dateAbnmnt)
    {
        $this->dateAbnmnt = $dateAbnmnt;

        return $this;
    }

    /**
     * Get dateAbnmnt
     *
     * @return \DateTime 
     */
    public function getDateAbnmnt()
    {
        return $this->dateAbnmnt;
    }

    /**
     * Set dateExpAbnmnt
     *
     * @param \DateTime $dateExpAbnmnt
     * @return Desabonnement
     */
    public function setDateExpAbnmnt($dateExpAbnmnt)
    {
        $this->dateExpAbnmnt = $dateExpAbnmnt;

        return $this;
    }

    /**
     * Get dateExpAbnmnt
     *
     * @return \DateTime 
     */
    public function getDateExpAbnmnt()
    {
        return $this->dateExpAbnmnt;
    }

    /**
     * Set typeAbnmnt
     *
     * @param integer $typeAbnmnt
     * @return Desabonnement
     */
    public function setTypeAbnmnt($typeAbnmnt)
    {
        $this->typeAbnmnt = $typeAbnmnt;

        return $this;
    }

    /**
     * Get typeAbnmnt
     *
     * @return integer 
     */
    public function getTypeAbnmnt()
    {
        return $this->typeAbnmnt;
    }

    /**
     * Set etatAbnmnt
     *
     * @param boolean $etatAbnmnt
     * @return Desabonnement
     */
    public function setEtatAbnmnt($etatAbnmnt)
    {
        $this->etatAbnmnt = $etatAbnmnt;

        return $this;
    }

    /**
     * Get etatAbnmnt
     *
     * @return boolean 
     */
    public function getEtatAbnmnt()
    {
        return $this->etatAbnmnt;
    }

    /**
     * Set dateDesabnmnt
     *
     * @param \DateTime $dateDesabnmnt
     * @return Desabonnement
     */
    public function setDateDesabnmnt($dateDesabnmnt)
    {
        $this->dateDesabnmnt = $dateDesabnmnt;

        return $this;
    }

    /**
     * Get dateDesabnmnt
     *
     * @return \DateTime 
     */
    public function getDateDesabnmnt()
    {
        return $this->dateDesabnmnt;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Desabonnement
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set motif
     *
     * @param integer $motif
     * @return Desabonnement
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return integer 
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
