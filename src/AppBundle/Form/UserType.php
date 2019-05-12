<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prenom')->add('nom')->add('tel')
            ->add('email', EmailType::class, array('label' => 'Email'))
            ->add('username', null, array('label' => 'Nom d\'Utilisateur'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer Mot de passe'),
                'invalid_message' => 'Les deux mots de passes ne correspondent pas!',
            ))
                ->add('roles', ChoiceType::class,array('choices'=>array(
                    'UTILISATEUR GP'=>"ROLE_GP",
                    "CONSEILLER CLIENT"=>"ROLE_CON_CLIENT",
                    "DIRECTEUR AGENCE"=>"ROLE_DIR_AGENCE",
                    "DIRECTEUR GENERAL"=>"ROLE_SUPER_ADMIN"), "multiple"=>true, 'expanded'=>true))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
