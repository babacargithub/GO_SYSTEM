<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercice
 *
 * @ORM\MappedSuperclass()
 */
class ExerciceBase
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="date")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="date")
     */
    private $dateEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=255)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="initialData", type="string", length=255)
     */
    private $initialData;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfHolidays", type="integer")
     */
    private $numberOfHolidays;


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
     * Set libelle
     *
     * @param string $libelle
     * @return Exercice
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Exercice
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Exercice
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set current
     *
     * @param boolean $current
     * @return Exercice
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return boolean 
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Exercice
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

    /**
     * Set initialData
     *
     * @param string $initialData
     * @return Exercice
     */
    public function setInitialData($initialData)
    {
        $this->initialData = $initialData;

        return $this;
    }

    /**
     * Get initialData
     *
     * @return string 
     */
    public function getInitialData()
    {
        return $this->initialData;
    }

    /**
     * Set numberOfHolidays
     *
     * @param integer $numberOfHolidays
     * @return Exercice
     */
    public function setNumberOfHolidays($numberOfHolidays)
    {
        $this->numberOfHolidays = $numberOfHolidays;

        return $this;
    }

    /**
     * Get numberOfHolidays
     *
     * @return integer 
     */
    public function getNumberOfHolidays()
    {
        return $this->numberOfHolidays;
    }
    
}
