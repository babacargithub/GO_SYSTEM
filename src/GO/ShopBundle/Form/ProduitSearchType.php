<?php

namespace  GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class ProduitSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 
                        'type'=>"Type de produit", 
                        'cat'=>"Catégorie", 
                        'nom_produit'=>'Nom Produit')))
                 ->add('value', 'text', array( "attr"=>array('class'=>"auto_com"),
                 'constraints' => array(
           new NotBlank())))
                 ->add('date_debut', 'date', array('widget'=>"single_text",
                 'required'=>false))
                 ->add('date_fin', 'date', array('widget'=>"single_text",
                         "required"=>false)
                 );
    
    }

    
    public function getName()
    {
        return 'go_shopbundle_vente_search_type';
    }
}
