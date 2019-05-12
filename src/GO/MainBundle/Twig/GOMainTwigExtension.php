<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  GO\MainBundle\Twig;

/**
 * Description of GOMainTwigExtension
 *
 * @author hp
 */
class GOMainTwigExtension extends \Twig_Extension {
    //put your code here
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('nombre', array($this, 'nombreFilter')),
            new \Twig_SimpleFilter('sum', array($this, 'sumFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
    public function nombreFilter($number, $decimals = 0, $decPoint = ',', $thousandsSep = ' ')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        return $price;
    }
    public function sumFilter($number)
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        return $price;
    }
    public function getName() {
        return 'go_main.twig_extension';
    }

}
