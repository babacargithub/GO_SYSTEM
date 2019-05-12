<?php

namespace  GO\CaisseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class EntreeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 'total'=>"Total des Entrées", 'liste'=>"Liste Des Entrées", 'type_entree'=>'Type D\'Entrée')))
                 ->add('date_debut', 'date', array('widget'=>"single_text",
                 'constraints' => array(
           new NotBlank())))
                 ->add('date_fin', 'date', array('widget'=>"single_text",
                         "required"=>false)
                 );
    
    }

    
    public function getName()
    {
        return 'go_caissebundle_entree_search_type';
    }
}
