<?php

namespace GO\ClientBundle\Entity;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * CompteClient
 *
 * @ORM\Table(name="crm_compte_client")
 * @ORM\Entity(repositoryClass="GO\ClientBundle\Repository\CompteClientRepository")
 */
class CompteClient extends AbstractCompte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \GO\MainBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="GO\ClientBundle\Entity\Client")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="client", referencedColumnName="id", nullable=false) })
     **/
    private $client;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    

    /**
     * Set client
     *
     * @param \GO\ClientBundle\Entity\Client $client
     *
     * @return CompteClient
     */
    public function setClient(\GO\ClientBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \GO\ClientBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
    
    //======public function==============
    public function generateAccountNumber(){
        try
        {
            if(!is_null($this->number))
            {
                return $this;
            }
            if(!empty($this->client)&&!empty($this->typeCompte))
            {
                $idClient=$this->client->getId();
                 $idTypeCompte=$this->typeCompte->getId();
                if(strlen($this->client->getId())===1)
                    $idClient.=$this->client->getId();
                if(strlen($this->typeCompte->getId())===1)
                   $idTypeCompte.=$this->typeCompte->getId();
            $number= $idTypeCompte.''.$idClient;
            $randomNumber=null;
            if(strlen($number)===4)
            $randomNumber=rand(pow(10, 2), pow(10, 3)-1);
            if(strlen($number)===5)
            $randomNumber=rand(pow(10, 1), pow(10, 2)-1);
            if(strlen($number)===6)
            $randomNumber=rand(pow(10, 0), pow(10, 1)-1);
            $number.=$randomNumber;
            $this->setNumber((int)$number);
            return $this;
            }else
            {
                throw new \Exception("Impossible de générer le numéro de compte! Une erreur s'est produite");
                
            }
        
            
        } catch (Exception $e)
        {
            echo $e->getMessage(); //throw new FatalErrorException($e->getMessage(), $e->getCode(), $e->getSeverity(), $e->getFile(), $e->getLine());
        }
    }
    //======public function==============
    public function generateBarcode(){
        try
        {
           $number= $this->getNumber();
            return $this; 
        } catch (FatalErrorException $e)
        {
            throw new FatalErrorException($e->getMessage(), $e->getCode(), $e->getSeverity(), $e->getFile(), $e->getLine());
        }
    }
}
