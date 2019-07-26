<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace GO\ShopBundle\Annotation;
/**
 * Description of UserSpecific
 *
 * @author LBC
 */
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class ShopSpecific
{
    public $filerBy;
}
