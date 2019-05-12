<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\DataTransformer\TelephoneToClientTransformer;
class CreanceLiquideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', 'client_selector')
            ->add('montant')
            ->add('dateEcheance','date', array('widget'=>"single_text"))
            
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\CreanceLiquide'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_creanceliquidetype';
    }
}
