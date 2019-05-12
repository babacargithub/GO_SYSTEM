<?php

namespace  GO\CaravaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\ClientBundle\Form\ClientType as BaseClientType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coordonnees',BaseClientType::class );
             
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\Client',
            'cascade_validation' => true,
        ));
    }

    public function getBlockPrefix(): string {
        return 'go_caravanebundle_clienttype';
    }

}
