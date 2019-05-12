<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Config;
use GO\MainBundle\Utils\Constants as Cons;

/**
 * Description of CarteKheweulConfig
 *
 * @author hp
 */
class CarteKheweulConfig {
    //put your code here
    protected $vars=array();
    public function __construct() {
        $this->load();
    }

    public function load()
    {
        if(empty($this->vars))
        {            //var_dump(__DIR__); die();
        $xml = new \DOMDocument;
        $xml->load('../src/GO/MainBundle/Resources/config/c_kheweul_settings.xml');
        $elements = $xml->getElementsByTagName('config');
        
        foreach ($elements as $element)
        {
        $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
        }
        }
    }
    public function get($var)
    {
        
        if (isset($this->vars[$var]))
        {
        return $this->vars[$var];
        } 
        return null;

    }
    public function getNombreVoy($condit=null)
    {
        switch ($condit)
        {
            case Cons::NOMBRE_VOY_STANDARD:
        return (int)$this->get('nombre_voy_std');
                break;
            case Cons::NOMBRE_VOY_PRO: return (int)$this->get('nombre_voy_pro');
                break;
            case Cons::NOMBRE_VOY_GOLD: return (int)$this->get('nombre_voy_gold');
                break;
            case Cons::NOMBRE_VOY_VIP: return (int) $this->get('nombre_voy_vip');
                break;
        }
        return null;
    }
}
