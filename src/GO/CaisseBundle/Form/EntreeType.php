<?php

namespace GO\CaisseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\CaisseBundle\Entity\Entree;

class EntreeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caisse_operation',ActiveCaisseType::class, array(
        'data_class' => Entree::class, "session"=>$options["session"]))
           ->add('typeEntree')
           ->add('libelle')
           ->add('montant')
           ->add('commentaire')
           ->add('auteur')
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaisseBundle\Entity\Entree'
        ))->setRequired("session");
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'go_caissebundle_entree';
    }


}
