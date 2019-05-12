<?php

namespace  GO\SMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class AbonnementSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 
                        'tel'=>"Téléphone Abonné", 
                        'prenom'=>"Prénom Abonné", 
                        'nom'=>"Nom Abonné",
                        'adresse'=>"Adresse Abonné",
                        'formule'=>"Abonnés d'une Formule",
                        'village'=>"Abonnés d'un Village",
                        'date'=>"Abonnés d'une date",
                        'sexe'=>"Abonnés d'un sexe",
                        'num_carte'=>'Numéro Carte')))
                 ->add('value', 'text', array(
                 'constraints' => array(
           new NotBlank())))
                ->add('formule', 'entity', array('class'=>"GOSMSBundle:Formule", "property"=>"libelle", "empty_value"=>"Sélectionnez la formule"))
                ->add('village', 'entity', array('class'=>"GOMainBundle:Village", "property"=>"nom", "empty_value"=>"Sélectionnez le village"))
           ;
    
    }

    
    public function getName()
    {
        return 'go_sms_bundle_abonnement_search_type';
    }
}
