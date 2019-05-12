<?php

namespace GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarteKheweulType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numCarte')
            ->add('dateDeliv', 'date', array('widget'=>'single_text'))
            ->add('dateExp', 'date', array('widget'=>'single_text'))
            ->add('client', 'integer', array('mapped'=>false))
            ->add('type', 'entity', array(
                'class'=>'GO\MainBundle\Entity\TypeCarte',
                'property'=>'libelle',
                'empty_value'=>'Sélectionnez le type de carte'
                ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\MainBundle\Entity\CarteKheweul'
        ));
    }

    public function getName()
    {
        return 'go_mainbundle_cartekheweultype';
    }
}
