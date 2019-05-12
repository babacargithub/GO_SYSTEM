<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('prenom')
                ->add('nom')
                ->add('tel')
                //->add('email')
                ->add('email', RepeatedType::class, array(
                        'type' => EmailType::class,
                        'invalid_message' => 'Les deux emails ne sont pas identiques.',
                        'options' => array('attr' => array('class' => 'password-field')),
                        'required' => true,
                        'first_options'  => array('label' => 'Email'),
                        'second_options' => array('label' => 'Répétez Email (ne pas copier)'),
                    ))
                ->add('dateNaiss', DateType::class, array(
                    'placeholder' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',),
                    "years" => array_combine(range(date("Y") - 12, date("Y") - 35), range(date("Y") - 12, date("Y") - 35))))
                ->add('lieuNaiss',TextType::class,array('label'=>"Lieu de Naissance"))
             
                ->add('sexe', ChoiceType::class, array("choices" => array("F" => "Féminin", "M" => "Masculin"), "expanded" => true, "multiple" => false))
                ->add('villeActuel',TextType::class,array('label'=>"Ville Actuelle"))
                ->add('anneeBac',ChoiceType::class, array("label"=>"Année du BAC","placeholder" => "Préciser année Bac","choices" => array_combine(range(date("Y"), date("Y") - 8), range(date("Y"), date("Y") - 8))))
                ->add('serie', ChoiceType::class, array("label"=>"Série BAC","placeholder" => "Série BAC","choices" => array("S" => "Scientifique", "L" => "Littérature")))
                ->add('etablissActuel',TextType::class,array('label'=>"Etablissement Actuel"))
                ->add('niveauActuel', EntityType::class, array('class' => 'AppBundle:Niveau', "placeholder" => "Niveau Actuel?"))
                ->add('formationActuel', TextType::class,array('label'=>"Formation Actuelle"))  
                ->add('remarques');
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Candidat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_candidat';
    }

}
