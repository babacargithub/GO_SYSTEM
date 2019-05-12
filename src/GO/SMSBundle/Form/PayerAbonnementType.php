<?php

namespace GO\SMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PayerAbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            ->add('annee')
            ->add('date')
            ->add('user')
            ->add('abonnement')
            ->add('mois')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\SMSBundle\Entity\PayerAbonnement'
        ));
    }

    public function getName()
    {
        return 'go_smsbundle_payerabonnementtype';
    }
}
