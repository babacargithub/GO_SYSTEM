<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;
/**
 * Description of AbstractEntityRepository
 *
 * @author LBC
 */
class AbstractEntityRepository extends EntityRepository{
    //put your code here
    public static function totalFilter(\Doctrine\ORM\QueryBuilder $qb,$entityAlias,$condition)
    {
        
    }
}
