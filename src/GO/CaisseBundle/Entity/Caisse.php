<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caisse
 *
 * @ORM\Table(name="caisse_pro")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\CaisseRepository")
 */
class Caisse extends AbstractCaisse
{
    
}

