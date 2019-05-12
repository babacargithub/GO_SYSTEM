<?php

namespace GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\PromoType;

class RemiseCarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('carte', 'entity', array('class'=>'GO\MainBundle\Entity\TypeCarte', 'property'=>"libelle"))
                ->add('promo', 'entity', array('class'=>'GO\MainBundle\Entity\Promo', 'property'=>"libelle"))
            ->add('tauxRemise', 'integer')
            ->add('dateFin', 'date', array('widget'=>'single_text'));
           
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\MainBundle\Entity\RemiseCarte'
        ));
    }

    public function getName()
    {
        return 'go_mainbundle_remisecartetype';
    }
}
