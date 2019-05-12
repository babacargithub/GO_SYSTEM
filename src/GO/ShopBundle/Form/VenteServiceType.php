<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VenteServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service','entity', array('class'=>'GOShopBundle:Service', 'property'=>'nom', 'empty_value'=>"Sélectionner un service"))
            ->add('montant','text', array("attr"=>array("class"=>"montant")))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\VenteService'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_venteservicetype';
    }
}
