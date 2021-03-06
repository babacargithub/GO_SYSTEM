<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sortie
 *
 * @ORM\Table(name="sortie_caisse")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\SortieRepository")
 */
class Sortie extends AbstractSortie
{
    

    /**
     * @var string
     *
     * @ORM\Column(name="justif_url", type="string", length=255, nullable=true)
     */
    private $justifUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="beneficiaire", type="string", length=255, nullable=true)
     */
    private $beneficiaire;


    /**
     * Set justifUrl
     *
     * @param string $justifUrl
     *
     * @return Sortie
     */
    public function setJustifUrl($justifUrl)
    {
        $this->justifUrl = $justifUrl;

        return $this;
    }

    /**
     * Get justifUrl
     *
     * @return string
     */
    public function getJustifUrl()
    {
        return $this->justifUrl;
    }

    /**
     * Set beneficiaire
     *
     * @param string $beneficiaire
     *
     * @return Sortie
     */
    public function setBeneficiaire($beneficiaire)
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }

    /**
     * Get beneficiaire
     *
     * @return string
     */
    public function getBeneficiaire()
    {
        return $this->beneficiaire;
    }
}
