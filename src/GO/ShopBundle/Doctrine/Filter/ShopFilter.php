<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Doctrine\Filter;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;
/**
 * Description of UserFilter
 *
 * @author LBC
 */
class ShopFilter extends SQLFilter {
    /**@var 
     * Reader
     */
    protected $reader;
    //put your code here
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string {
        if(empty($this->reader))
        {
            return "";
        }
        $shopSpecificAnnotation= $this->reader->getClassAnnotation($targetEntity->getReflectionClass(), "GO\\ShopBundle\\Annotation\\ShopSpecific");
        if(!$shopSpecificAnnotation)
        {
            return "";
        }
        $filterBy=$shopSpecificAnnotation->filterBy;
        try{
            $shopId= $this->getParameter("shop_id");
        } catch (Exception $ex) {
            return $ex;
        }
        return $query_filer= sprintf('%.%=%',$targetTableAlias,$filterBy,$shopId);
    }
    // helps use the doctrine annotation reader, which fetches information from the annotation  UserSpecific of target class
    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }

}
