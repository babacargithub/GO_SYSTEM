<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            ->add('charge','entity', array(
                'class'=>'GOShopBundle:Charge', 
                'property'=>'libelle', 
                'empty_value'=>'Préciser La Dépense', 
                ))
             ->add('justif');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Sortie'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_sortietype';
    }
}
