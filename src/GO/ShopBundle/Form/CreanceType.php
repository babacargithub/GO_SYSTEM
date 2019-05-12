<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client')
            ->add('produitt')
            ->add('quantite')
            ->add('prixUnit')
            ->add('dateCreance')
            ->add('dateEcheance')
            ->add('rembourse')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Creance'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_creancetype';
    }
}
