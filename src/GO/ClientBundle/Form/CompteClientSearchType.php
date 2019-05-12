<?php

namespace  GO\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class CompteClientSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('value', Types\TextType::class, array(
                "label"=>"Valeur à rechercher",
                 'constraints' => array(
           new NotBlank())))
                ->add('type_search', 'choice', 
                        array('placeholder'=>'Rechercher par', 
                    'choices'=>array( 'account_number'=>"Numéro de compte")));
                
    }

    
    public function getName()
    {
        return 'go_clientbundle_client_search_type';
    }
}
