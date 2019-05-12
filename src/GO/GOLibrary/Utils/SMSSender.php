<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Utils;

/**
 * Description of SMSSender
 *
 * @author hp
 */
class SMSSender {
    //put your code here
    public static function send($tel,$message)
    {
        				
        $data = array(
                    "outboundSMSMessageRequest" =>array(
                        "address"=>"tel:+221".trim($tel)."",
                        "senderAddress"=>"tel:+221773300853", "senderName"=>"GolobOne",
                        "outboundSMSTextMessage"=>array("message"=>$message)));

        $data_string = json_encode($data); 

        //var_dump($data_string);    die();                                                                                                  
        $ch = curl_init('https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B221773300853/requests');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization: Bearer Z7WAaIe9VKEf3dYXsd2MtrrpJrj8',
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );  
          $rep=curl_exec($ch);
          return $rep;
          
          
    }
    public static function getToken()
    {
        				
        $data ="grant_type=client_credentials";

        $data_string = json_encode($data); 

        //var_dump($data_string);    die();                                                                                                  
        $ch = curl_init('https://api.orange.com/oauth/v2/token');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization: Basic WUExRmhzejRLblN0SWFhUjQ5VUFmWWlnaEtKWEprYU46QUdHcFEzMEQ1UEExbEdOcg==',
            'Content-Type: application/x-www-form-urlencoded',                                                                                
            'Content-Length: ' . strlen($data))                                                                       
        );  
          $rep=curl_exec($ch);
          return $rep;
          
          
    }
}
