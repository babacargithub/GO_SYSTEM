<?php

namespace GO\CaisseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\CaisseBundle\Entity\CaisseUser;

class CaisseUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caissier')
                ->add('caisse')
                ->add('openningAt', TimeType::class, array("label"=>"Heure d'Ouverture"))
                ->add('closingAt',TimeType::class, array("label"=>"Heure Fermeture"))
                ->add('accessLevel', ChoiceType::class, array("label"=>"Niveau D'accès", "choices"=>array(
                    CaisseUser::ACCES_NIVEAU_CAISSIER=>"Accès Niveau Caissier Simple",
                    CaisseUser::ACCES_NIVEAU_CHEF_CAISSE=>"Accès Niveau Chef de Caisse",
                    CaisseUser::ACCES_NIVEAU_SUPERVISEUR=>"Accès Niveau Superviseur",
                    CaisseUser::ACCES_NIVEAU_ADMIN=>"Accès Niveau Administrateur",
                    ), "placeholder"=>"Préciser le Niveau d'accès"
                    )
                        )
                ->add('comments');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaisseBundle\Entity\CaisseUser'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'go_caissebundle_caisseuser';
    }


}
