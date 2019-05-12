<?php

namespace GO\CaisseBundle\Repository;
use GO\CaisseBundle\Entity\Caisse;
use GO\CaisseBundle\Entity\TypeEntree;
use GO\GOLibrary\Utils\DateConstants as Cons;


/**
 * EntreeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EntreeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getListeEntree(Caisse $caisse, $condition,$date_debut=null, $date_fin=null)
    {
        $qb= $this->createQueryBuilder('e');
        switch($condition)
        {
            case Cons::AUJOURDHUI: $qb->where('DATE(e.date)=CURRENT_DATE()');
                break;
            case Cons::MOIS: $qb->where('MONTH(e.date)=MONTH(CURRENT_DATE()) AND YEAR(e.date)=YEAR(CURRENT_DATE())');
                break;
            case Cons::DATE_INTERVALLE: 
                if(!is_null($date_debut))
                {
                    $qb->where('DATE(e.date)>=:date_debut');
                    $qb->setParameter('date_debut', $date_debut);
                    if(!is_null($date_fin))
                    {
                        $qb->andWhere('DATE(e.date)<=:date_fin');
                        $qb->setParameter('date_fin', $date_fin);
                    }
                }else
                {
                    throw new \RuntimeException('Aucune date entrée ou format date invalide!');
                }
                break;
        }
         $qb->andWhere('e.caisse=:caisse');
         $qb->setParameter('caisse', $caisse);
         $qb->orderBy('e.date', 'DESC');
       
        return $qb->getQuery()
                ->getResult();
    }
    public function getTotalEntree(Caisse $caisse, $condition,$date_debut=null, $date_fin=null)
    {
        $qb= $this->createQueryBuilder('s')
                ->select('SUM(s.montant)');
         switch($condition)
        {
            case Cons::AUJOURDHUI: $qb->where('DATE(s.date)=CURRENT_DATE()');
                break;
            case Cons::MOIS: $qb->where('MONTH(s.date)=MONTH(CURRENT_DATE()) AND YEAR(s.date)=YEAR(CURRENT_DATE())');
                break;
            case Cons::DATE_INTERVALLE: 
                if(!is_null($date_debut))
                {
                    $qb->where('DATE(s.date)>=:date_debut');
                    $qb->setParameter('date_debut', $date_debut);
                    if(!is_null($date_fin))
                    {
                        $qb->andWhere('DATE(s.date)<=:date_fin');
                        $qb->setParameter('date_fin', $date_fin);
                    }
                }else
                {
                    throw new \RuntimeException('Aucune date entrée ou format date invalide!');
                }
                break;
        }
                $qb->andWhere('s.caisse=:caisse');
                $qb->setParameter('caisse', $caisse);
               return $qb->getQuery()->getSingleScalarResult();
        
    }
    public function getListeTypeEntree(Caisse $caisse,TypeEntree $type, $condition,$date_debut=null, $date_fin=null)
    {
        $qb= $this->createQueryBuilder('e');
        switch($condition)
        {
            case Cons::AUJOURDHUI: $qb->where('DATE(e.date)=CURRENT_DATE()');
                break;
            case Cons::MOIS: $qb->where('MONTH(e.date)=MONTH(CURRENT_DATE()) AND YEAR(e.date)=YEAR(CURRENT_DATE())');
                break;
            case Cons::DATE_INTERVALLE: 
                if(!is_null($date_debut))
                {
                    $qb->where('DATE(e.date)>=:date_debut');
                    $qb->setParameter('date_debut', $date_debut);
                    if(!is_null($date_fin))
                    {
                        $qb->andWhere('DATE(e.date)<=:date_fin');
                        $qb->setParameter('date_fin', $date_fin);
                    }
                }else
                {
                    throw new \RuntimeException('Aucune date entrée ou format date invalide!');
                }
                break;
        }
         $qb->andWhere('e.caisse=:caisse');
         $qb->setParameter('caisse', $caisse);
         $qb->orderBy('e.date', 'DESC');
       
        return $qb->getQuery()
                ->getResult();
    }
    public function getTotalEntreeType(Caisse $caisse, TypeEntree $type,$condition,$date_debut=null, $date_fin=null)
    {
        $qb= $this->createQueryBuilder('e')
                ->select('SUM(e.montant)');
         switch($condition)
        {
            case Cons::AUJOURDHUI: $qb->where('DATE(e.date)=CURRENT_DATE()');
                break;
            case Cons::MOIS: $qb->where('MONTH(e.date)=MONTH(CURRENT_DATE()) AND YEAR(e.date)=YEAR(CURRENT_DATE())');
                break;
            case Cons::DATE_INTERVALLE: 
                if(!is_null($date_debut))
                {
                    $qb->where('DATE(e.date)>=:date_debut');
                    $qb->setParameter('date_debut', $date_debut);
                    if(!is_null($date_fin))
                    {
                        $qb->andWhere('DATE(e.date)<=:date_fin');
                        $qb->setParameter('date_fin', $date_fin);
                    }
                }else
                {
                    throw new \RuntimeException('Aucune date entrée ou format date invalide!');
                }
                break;
        }
                $qb->andWhere('e.caisse=:caisse')->setParameter('caisse', $caisse);
                 $qb->andWhere('e.typeEntree=:type')->setParameter('type', $type);
               return $qb->getQuery()->getSingleScalarResult();
        
    }
}
