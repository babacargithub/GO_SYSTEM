<?php

namespace  GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class ClientSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('value', 'text', array(
                 'constraints' => array(
           new NotBlank())))
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 'tel'=>"Numéro téléphone", 'prenom'=>"Prénom", 'nom'=>"Nom",'num_carte'=>'Numéro Carte', "ufr"=>"UFR", "section"=>"Section")))
                ->add("ufr", 'entity', array('class'=>"GOMainBundle:Ufr", "empty_value"=>"Selectioner UFR",'required'=>false))
                ->add("section", 'entity', array('class'=>"GOMainBundle:Section","empty_value"=>"Select Section",'required'=>false));
    
    }

    
    public function getName()
    {
        return 'go_mainbundle_client_search_type';
    }
}
