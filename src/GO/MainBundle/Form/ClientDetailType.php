<?php

namespace  GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', 'text', array("label"=>"Prénom"))
            ->add('nom', 'text')
            ->add('tel', 'text')
            ->add('adresse', 'text',array("required"=>false ))
            ->add('promo', 'text', array("required"=>false))
            ->add('nombre_voy', 'text', array('mapped'=>false, "required"=>false))
            
            //->add('depart', new DepartType());
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\MainBundle\Entity\Client'
        ));
    }

    public function getName()
    {
        return 'go_mainbundle_clientdetailtype';
    }
}
