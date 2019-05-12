<?php

namespace  GO\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ClientSearchType extends AbstractType
{
    const SEARCH_BY_FIRSTNAME="firstname",
    SEARCH_BY_LASTTNAME="lastname",
    SEARCH_BY_TEL="tel",
    SEARCH_BY_EMAIL="email",
    SEARCH_BY_ADRESSE="adresse",
    SEARCH_BY_SEXE="sexe",
    SEARCH_BY_CATEGORIE="cat";
            

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
           ->add('type_search', Types\ChoiceType::class, 
                       array("label"=>"Type de recherche",'empty_value'=>'Rechercher par', 
                    'choices'=>array( 
                        self::SEARCH_BY_TEL=>"Numéro téléphone", 
                        self::SEARCH_BY_FIRSTNAME=>"Prénom", 
                        self::SEARCH_BY_LASTTNAME=>"Nom",
                        self::SEARCH_BY_SEXE=>"Sexe", 
                        self::SEARCH_BY_CATEGORIE=>"Type de Client")))
               ->add('value', Types\TextType::class, array(
                 'constraints' => array(new NotBlank())
                   )) ;
    }

    
    public function getName()
    {
        return 'go_clientbundle_client_search_type';
    }
}
