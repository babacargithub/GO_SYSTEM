<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;

class ProduitExportType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('categorie', 'entity', array(
                'class'=>'GOShopBundle:Categorie', 
                'property'=>'nom', 
                'empty_value'=>'Sélectionner une catégorie', 
                ))
        ;
    }


    public function getName()
    {
        return 'go_shopbundle_produitexporttype';
    }
}
