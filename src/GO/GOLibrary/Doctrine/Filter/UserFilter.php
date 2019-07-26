<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\GOLibrary\Doctrine\Filter;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;
/**
 * Description of UserFilter
 *
 * @author LBC
 */
class UserFilter extends SQLFilter {
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
        $userSpecificAnnotation= $this->reader->getClassAnnotation($targetEntity->getReflectionClass(), "GO\\GOLibrary\\Annotation\\UserSpecific");
        if(!$userSpecificAnnotation)
        {
            return "";
        }
        $filterBy=$userSpecificAnnotation->filterBy;
        try{
            $userId= $this->getParameter("user_id");
        } catch (Exception $ex) {
            return $ex;
        }
        return $query_filer= sprintf('%.%=%',$targetTableAlias,$filterBy,$userId);
    }
    // helps use the doctrine annotation reader, which fetches information from the annotation  UserSpecific of target class
    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }

}
