<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Utils;

/**
 * Description of Constants
 *
 * @author hp
 */
class Constants extends \GO\MainBundle\Utils\Constants {
    //put your code here
    const DAKAR_UGB=2;
    const UGB_DAKAR=1;
    const DESTINATION_DAKAR=2;
    const DESTINATION_THIES=1;
    const PAYE=true;
    const NON_PAYE=false;
    const USER='user';
    const DEPART='depart';
    const EVENT='event';
    const DEPART_TROIS_JR=1;
    const DEPART_NON_PASSE=2;
    const DEPART_PASSE=3;
    const POINT_DEP="point_dep";
    const NUM_RESERVATION="77 127 35 35";
    public static function getListeTrajets()
    {
        return array(array('libelle'=>"UGB ver DAKAR", "value"=>1, "abrv"=>"UGB-DK"),
        array('libelle'=>"DAKAR vers UGB", "value"=>2, "abrv"=>"DK-UGB"));
    }
    public static function getListeHoraires()
    {
        
    }
}
