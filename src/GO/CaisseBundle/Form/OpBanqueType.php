<?php

namespace GO\CaisseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\CaisseBundle\Entity\OpBanque;

class OpBanqueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('compte')
                ->add('typeOp',ChoiceType::class, array("label"=>"Type Opération", "choices"=>
                                                                array(OpBanque::VERSEMENT=>"Versement Sortant",
                                                                      OpBanque::RETRAIT=>"Versement Entrant",
                                                                      OpBanque::VIREMENT_EMIS=>"Virement Emis",
                                                                      OpBanque::VIREMENT_RECU=>"Virement Reçu"))
                     )
                ->add('montant')
                ->add('justif')
                ->add('caisse_operation',ActiveCaisseType::class, array(
        'data_class' => OpBanque::class, "session"=>$options["session"]));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaisseBundle\Entity\OpBanque'
        ))->setRequired('session');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'go_caissebundle_opbanque';
    }


}
