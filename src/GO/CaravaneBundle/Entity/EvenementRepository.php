<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Entity;
use GO\CaravaneBundle\Utils\Constants as Cons;

use Doctrine\ORM\EntityRepository;
Class EvenementRepository extends EntityRepository{
    //put your code here
    public function getEventsEncours($condition=null)
    {
        $qb=$this->createQueryBuilder('ev')
        ->where('DATE(ev.dateEnd)>=CURRENT_DATE()');
        if($condition==Cons::UGB_DAKAR)
        {
            $qb->andWhere(('ev.trajet=:tra'));
            $qb->setParameter('tra', 1);
        }
        elseif($condition==Cons::DAKAR_UGB)
        {
            $qb->andWhere(('ev.trajet=:tra'));
            $qb->setParameter('tra', 2);
        }
       
        $qb->orderBy('ev.dateEnd', 'DESC');
        return $qb;
    }
    public function getListeEvents($condition=null)
    {
        $qb=$this->createQueryBuilder('ev')
        ->where('DATE(ev.dateEnd)>=CURRENT_DATE()');
        if($condition==Cons::UGB_DAKAR)
        {
            $qb->andWhere(('ev.trajet=:tra'));
            $qb->setParameter('tra', 1);
        }
        elseif($condition==Cons::DAKAR_UGB)
        {
            $qb->andWhere(('ev.trajet=:tra'));
            $qb->setParameter('tra', 2);
        }
        $qb->join('GO\CaravaneBundle\Entity\Depart', 'd', "WITH", "d.event=ev.id");
        $qb->join('GO\CaravaneBundle\Entity\Reservation', 'r', "WITH", "r.depart=d.id");
        $qb->addSelect('COUNT(d.event) as num_insc');
        $qb->orderBy('ev.dateEnd', 'DESC');
        return $qb;
    }
    public function getCurrentEvent($filter=null)
    {
        $qb=$this->createQueryBuilder('ev')
        ->where('DATE(ev.dateEnd)>=CURRENT_DATE()');
        if($filter==Cons::UGB_DAKAR)
        {
            $qb->andWhere(('ev.trajet=:tra'));
            $qb->setParameter('tra', 1);
        }
        elseif($filter==Cons::DAKAR_UGB)
        {
            $qb->andWhere(('ev.trajet=:tra'));
            $qb->setParameter('tra', 2);
        }
        $qb->orderBy('ev.dateEnd', 'DESC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getSingleResult();
    }
    
}
