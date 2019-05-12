<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\GOLibrary\HTTP;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AjaxJsonResponse
 * Cette classe permet de préparer et de formater une réponse au format json 
  qui sera exploitée par les appels ajax côté client
 * Elle permet aussi de préparer les réponses pour les Api
 * Elle dépend de la classe Response de Symfony/HttpFondation
 *
 * @author LBC
 */
class AjaxJsonResponse {
    //put your code here
    //représente le type de réponse, qui peut prendre 3 valeurs "success", "error", "redirect"
    public $type,
            //le message qui sera envoyé aux clients en cas de success ou erreur
            $message, 
            // représente le codde HTTP par ex 200, 201, 500, 404, 400, 303, 403
            $code,
            //contient les données qui sont renvoyés par la requête. Par exemple, un formulaire, une liste d'objets etc
            $data, 
            // si la réponse demande une redirection, cette variable contiendra l'url à laquelle rediriger la requette
            $redirectUrl;
    
    //Ces constantes permttent de définir le type de réponse
    const STATUS_SUCCESS="success", STATUS_ERROR="error", STATUS_REDIRECT="redirect";

    public function __construct()
    {
        $this->redirectUrl = null;
    }
    public function getType() {
        return $this->type;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getCode() {
        return $this->code;
    }

    public function getData() {
        return $this->data;
    }

    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setRedirectUrl($redirectUrl) {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

        /*
     *@return array
     */
    public function getResponseArray()
    {
        return array("type"=>$this->type,"message"=>$this->message,"data"=> $this->data, "code"=> $this->code,"redirectUrl"=> $this->redirectUrl);
    }
        /*
     *@return array
     */
    public function createSuccessResponseArray($message,$code=null,$data=null)
    {
        if(null===$code) 
        {$code=Response::HTTP_OK;
        }
        return array("type"=>self::STATUS_SUCCESS,"message"=>$message,"data"=> $data, "code"=>$code ,"redirectUrl"=> $this->redirectUrl);
    }
        /*
     *@return array
     */
    public function createErrorResponseArray($message,$code=null,$data=null)
    {
        if(null===$code) 
        {$code=Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        return array("type"=>self::STATUS_ERROR,"message"=>$message,"data"=> $data, "code"=>$code ,"redirectUrl"=> $this->redirectUrl);
    }

    /* return boolean
     * 
     */
    public function hasRedirect()
    {
        return null!==$this->redirectUrl;
    }
}
