<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class rapportJourneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('wari')
            ->add('om')
            ->add('caisse')
            ->add('sortie')
            ->add('entree')
            ->add('mar')
            ->add('mrendu')
            ->add('marecup')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\rapportJournee'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_rapportjourneetype';
    }
}
