<?php

namespace GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class CarteKheweulSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'text', array(
                 'constraints' => array(
           new NotBlank())))
                ->add('type_search', 'choice', array('empty_value'=>'Rechercher par', 'choices'=>array('num_carte'=>'Numéro Carte', 'tel'=>"Numéro téléphone", 'num_client'=>"Numéro Client")));
    }

    public function getName()
    {
        return 'go_mainbundle_cartekheweulsearchtype';
    }
}
