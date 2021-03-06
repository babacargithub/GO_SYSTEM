<?php

namespace GO\CaravaneBundle\Entity;

use Doctrine\ORM\EntityRepository;
use GO\CaravaneBundle\Utils\Constants as Cons;

/**
 * DepartRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DepartRepository extends EntityRepository
{
    public function getListeDeparts($filter=null)
    {
        $qb= $this->createQueryBuilder('d');
        $condition="";
        if(!is_null($filter))
        {
            if($filter== Cons::DEPART_TROIS_JR)
            {
                $condition="d.date>= :intval";
		$qb->where($condition);
                $qb->setParameter('intval', new \DateTime('-3 days'));
            }
            elseif($filter== Cons::DEPART_NON_PASSE)
            {
                $condition="d.date>=NOW()";
		$qb->where($condition);
                //$qb->setParameter('intval', new \DateTime('-3 days'));
            }
            elseif($filter== Cons::DEPART_PASSE)
            {
                $condition="d.date<NOW()";
		$qb->where($condition);
		$qb->andWhere("d.event=:lastEvent");
                $lastEvent= $this->getEntityManager()->getRepository('\GO\CaravaneBundle\Entity\Evenement')->getCurrentEvent();
                $qb->setParameter('lastEvent', $lastEvent->getId());
            }
        
                
        }else{
        
                $qb->where('d.date >=NOW()');
                //->where('TIME(d.date) >= CURRENT_TIME()');
                
               // ->setParameter('date', 'CURRENT');
        }
        $qb->orderBy('d.date');
        
        return $qb;
        
    }
    

    public function getDepartsEvent($event)
    {
        $qb= $this->createQueryBuilder('d')
                ->where('d.event=:event')
               ->setParameter('event', $event)
                ->orderBy('d.date','DESC');
        return $qb->getQuery()->getResult();
        
    }
}
