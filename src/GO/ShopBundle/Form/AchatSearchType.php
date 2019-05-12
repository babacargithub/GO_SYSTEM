<?php

namespace  GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class AchatSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            
                ->add('type_search', 'choice', 
                        array('empty_value'=>'Rechercher par', 
                    'choices'=>array( 'total_achat'=>"Total Des Achats",
                                    'liste_achat'=>"Produits Achetés", 
                                    'liste_fac_paye'=>'Factures  Payées',
                                    'liste_fac_non_paye'=>'Factures Non Payées',
                        'liste_fac'=>'Toutes Factures',
                                    )))
                 ->add('date_debut', 'date', array('widget'=>"single_text",
                 'constraints' => array(
           new NotBlank())))
                 ->add('date_fin', 'date', array('widget'=>"single_text",
                         "required"=>false)
                 );
    
    }

    
    public function getName()
    {
        return 'go_shopbundle_vente_search_type';
    }
}
