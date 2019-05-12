<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;

class ProduitType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('nom')
            ->add('type', 'entity',array('class'=>'GOShopBundle:TypeProduit','empty_value'=>"Sélectionnez type de produit"))
            ->add('prixAchat')
            ->add('prixVente')
            ->add('descrip')
            ->add('categorie', 'entity', array(
                'class'=>'GOShopBundle:Categorie', 
                'property'=>'nom', 
                'empty_value'=>'Sélectionner une catégorie', 
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Produit'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_produittype';
    }
}
