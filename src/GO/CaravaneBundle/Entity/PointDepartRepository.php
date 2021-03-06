<?php

namespace GO\CaravaneBundle\Entity;
use GO\CaravaneBundle\Utils\Constants as Cons;
use Doctrine\ORM\EntityRepository;

/**
 * DepartRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PointDepartRepository extends EntityRepository
{
    public function getListePointDeparts($trajet=null)
    {
        $qb= $this->createQueryBuilder('pd');
        if(!is_null($trajet))
        {
            if($trajet==Cons::UGB_DAKAR)
            {
                $qb->where('pd.trajet=1');
            }
            elseif ($condi==Cons::DAKAR_UGB)
            {  $qb->where('pd.trajet=2');
            }
        }
        
        return $qb;
        
    }
}
