<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Utils;

/**
 * Description of TextExporter
 *
 * @author hp
 */
class TextExporter extends Exporter {
    //put your code here
    
    public function export($data, $filename, array $options=array())
    {
        if(is_file($filename))
        {
	unlink($filename);
        }
	$myfile=fopen($filename, 'a+');
        fputs($myfile, $data);	
	if (file_exists($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
    }
        
    }
}
