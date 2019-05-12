<?php

namespace GO\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use GO\ClientBundle\Entity\TypeCompte;
use GO\ClientBundle\Form\ClientSelectorType;

class CompteClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('number', Types\IntegerType::class, array('label'=>'Numéro Compte') );
        $builder->add('TypeCompte', EntityType::class, array("class"=>TypeCompte::class,"label"=>"Type de Compte", "placeholder"=>"Sélectionner Type de Compte") );
        $builder->add('client', ClientSelectorType::class, array('label'=>'Les coordonnées du client ') );
       
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ClientBundle\Entity\CompteClient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'go_clientbundle_compteclient';
    }


}
