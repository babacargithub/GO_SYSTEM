<?php

namespace  GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class SortieSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 'total'=>"Total Sortie", 'liste'=>"Liste Des Sorties", 'poste_depense'=>'Type de Sortie')))
                 ->add('typeSortie',EntityType::class, 
                         array("class"=>"GO\ShopBundle\Entity\Charge", 
                             "property"=>"libelle", 
                             "placeholder"=>"Préciser Type de Sortie", "attr"=>array("display"=>"none")) )
                 ->add('date_debut', 'date', array('widget'=>"single_text",
                 'constraints' => array(
           new NotBlank())))
                 ->add('date_fin', 'date', array('widget'=>"single_text",
                         "required"=>false)
                 );
    
    }

    
    public function getName()
    {
        return 'go_shopbundle_sortie_search_type';
    }
}
