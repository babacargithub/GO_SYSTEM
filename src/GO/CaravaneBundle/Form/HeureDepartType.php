<?php

namespace GO\CaravaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeureDepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart')
            ->add('pointDep','entity',array('class'=>"GOCaravaneBundle:PointDepart",'disabled'=>true))
            ->add('heureDepart','time',array('widget'=>"single_text"))
            ->add('arretBus')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\HeureDepart'
        ));
    }

    public function getName()
    {
        return 'go_caravanebundle_heuredeparttype';
    }
}
