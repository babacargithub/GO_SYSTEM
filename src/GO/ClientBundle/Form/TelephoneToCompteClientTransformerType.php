<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ClientBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\ClientBundle\Form\DataTransformer\NumCompteToIdTransformer;
class TelephoneToCompteClientTransformerType extends AbstractType{
    //put your code here
    private $manager;
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new TelephoneToCompteTransformer($this->manager));
    }
    public function getParent() {
        return "text";
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'Aucun compte client n\'existe avec ce numéro! ',
        ));
    }
     public function getName()
    {
        return 'tel_to_compte_client_transformer';
    }


}
