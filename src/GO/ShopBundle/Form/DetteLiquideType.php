<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\DataTransformer\TelephoneToClientTransformer;
class DetteLiquideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creancier', 'entity',array('class'=>"GOShopBundle:Creancier","property"=>"prenom", "empty_value"=>"Qui est le prêteur?"))
            ->add('montant')
            ->add('dateDette')
            ->add('dateEcheance')
           
            
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\DetteLiquide'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_detteliquidetype';
    }
}
