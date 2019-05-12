<?php

namespace GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('description', 'textarea')
            ->add('dateDebut', 'date', array('widget'=>'single_text'))
            ->add('dateFin', 'date', array('widget'=>'single_text'));
              //->add('remise', new RemiseCarteType(), array('mapped'=>false));
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\MainBundle\Entity\Promo'
        ));
    }

    public function getName()
    {
        return 'go_mainbundle_promotype';
    }
}
