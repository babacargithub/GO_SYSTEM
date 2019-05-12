<?php

namespace  GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class VenteSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 'total'=>"Total ventes", 
                                      'benefice'=>"Bénéfices", 
                                    'liste'=>"Produits vendus"
                                    )))
                 ->add('debut', 'date', array('widget'=>"single_text",
                 'constraints' => array(
           new NotBlank())))
                 ->add('fin', 'date', array('widget'=>"single_text",
                         "required"=>false)
                 );
    
    }

    
    public function getName()
    {
        return 'go_shopbundle_vente_search_type';
    }
}
