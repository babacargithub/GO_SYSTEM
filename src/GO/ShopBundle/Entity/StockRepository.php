<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StockRepository extends EntityRepository
{
    public function getEtatStock(Shop $shop)
    {
        $qb=$this->createQueryBuilder('s')
        ->join('s.produit',' p')
              //  ->join('GOShopBundle:TypeProduit',' t', 'WITH', 'p.type=t.id')
       
        ->addSelect('SUM(p.prixAchat*s.quantite) as total_stock')
         // ->addSelect('t')
        ->where('s.shop=:shop')
        ->setParameter('shop', $shop)
        ->groupBy('p.type');
        return $qb->getQuery()->getResult();
    }
    public function getValeurStock(Shop $shop)
    {
        $qb=$this->createQueryBuilder('s')
        ->join('s.produit','p')
         ->select('SUM(p.prixAchat*s.quantite) as total_stock')
        ->where('s.shop=:shop')
        ->setParameter('shop', $shop);
        return $qb->getQuery()->getSingleScalarResult();
    }
}
