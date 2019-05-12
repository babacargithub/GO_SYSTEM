<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends EntityRepository
{
    public function getResEnCours($tel)
    {
       return $this->createQueryBuilder('c')
                ->join('c.reservations', 'r')
                ->addSelect('r')
               ->where('SUBSTRING(c.tel,-9,9)=:tel')
               
               ->setParameter('tel', $tel)
                ->getQuery()
                ->getResult();
    }
    public function getClientsKheweul($condition)
    {
        $qb= $this->createQueryBuilder('c');
        $qb->join('GO\CaravaneBundle\Entity\Reservation', 'r', 'WITH', 'r.client=c.id')
                ->addSelect('COUNT(r.client) as num_voy')
                ;
       
         $qb->groupBy('r.client'); 
         $qb->having('num_voy >=1');
        //$qb->setParameter('num', $condition);
       $qb->orderBy('num_voy', 'DESC');
        ;
        return $qb->getQuery()->getResult();
                
    }
    public function getAll()
    {
        $qb= $this->createQueryBuilder('c');
        $qb->leftJoin('GO\CaravaneBundle\Entity\Reservation', 'r', 'WITH', 'r.client=c.id')
                ->addSelect('COUNT(r.client) as num_voy')
                ;
       
         $qb->groupBy('r.client'); 
         //$qb->having('num_voy >=1');
        //$qb->setParameter('num', $condition);
       $qb->orderBy('num_voy', 'DESC');
        ;
        return $qb->getQuery()->getResult();
                
    }
    public function getNombreVoyage($tel)
    {
       return $qb=$this->createQueryBuilder('c')
               
                ->join('GO\CaravaneBundle\Entity\Reservation','r','WITH','r.client=c.id')
               ->select('COUNT(r.id)')
               ->where('SUBSTRING(c.tel,-9,9)=:tel')
               ->setParameter('tel', $tel)
                ->getQuery()
                ->getSingleScalarResult();
      
    }
    public function findOneByTel($tel)
    {
        return $this->createQueryBuilder('c')
               ->where('SUBSTRING(c.tel,-9,9)=:tel')
               ->setParameter('tel', $tel)
                ->orderBy('c.id','DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
    }
    
   
}
