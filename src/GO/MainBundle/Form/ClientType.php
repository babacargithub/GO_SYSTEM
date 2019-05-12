<?php

namespace  GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', 'text', array("label"=>"Prénom"))
            ->add('nom', 'text')
            ->add('tel', 'integer')
            ->add('adresse', 'text',array("required"=>false))
            ->add('promo', 'text', array("required"=>false))
            ->add('sexe', 'text', array("required"=>false))
            ->add('ufr', 'entity', array("class"=>"GOMainBundle:Ufr","empty_value"=>"Sélectionner UFR","required"=>false))
            ->add('Section', 'entity', array("class"=>"GOMainBundle:Section","empty_value"=>"Sélectionner Section","required"=>false))
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
        return 'go_mainbundle_clienttype';
    }
}
