<?php

namespace  GO\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompteClient
 *
 * @ORM\Table(name="crm_client")
 * @ORM\Entity(repositoryClass="GO\ClientBundle\Repository\ClientRepository")
 */
class Client extends AbstractClient
{
    /**
     * @var override
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
       /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
