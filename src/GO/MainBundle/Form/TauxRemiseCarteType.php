<?php

namespace GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\PromoType;

class TauxRemiseCarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('carte', 'entity', array('class'=>'GO\MainBundle\Entity\TypeCarte', 'property'=>"libelle"))
                ->add('tauxRemise', 'integer');
           
    }

    

    public function getName()
    {
        return 'go_mainbundle_tauxremisecartetype';
    }
}
