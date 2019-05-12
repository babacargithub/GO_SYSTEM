<?php

namespace GO\CaravaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('tel')
            ->add('observations') ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\Chauffeur'
        ));
    }

    public function getName()
    {
        return 'go_caravanebundle_chauffeurtype';
    }
}
