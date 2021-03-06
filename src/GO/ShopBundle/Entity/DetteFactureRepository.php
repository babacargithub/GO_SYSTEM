<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DetteFactureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DetteFactureRepository extends EntityRepository
{
    public function getTotalDetteNonRemb(Shop $shop,$depuis=null)
    {
        $qb=$this->createQueryBuilder('d');
        $qb->join('GO\ShopBundle\Entity\FactureAchat', 'fac', 'WITH', 'fac.id=d.facture')
        ->join('GO\ShopBundle\Entity\Achat', 'ach', 'WITH', 'ach.facture=fac.id')
        ->select('SUM(ach.quantite*ach.prixUnit)')
        ->where('d.rembourse=:bool')
        ->setParameter('bool', false)
        ->andWhere('fac.paye=:bool')
        ->setParameter('bool', false)
        ->andWhere('d.shop=:shop')
        ->setParameter('shop', $shop)
        ->andWhere('d.dateDette>=:date')
        ->setParameter('date', $depuis);
        return $qb->getQuery()->getSingleScalarResult();
    }
}
