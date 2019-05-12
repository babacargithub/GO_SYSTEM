<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Utils;

/**
 * Description of Exporter
 *
 * @author hp
 */
abstract class Exporter {
    //put your code here
    protected $filename;
    abstract function export($dataSource, $filename, array $options=array());
}
