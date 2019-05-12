<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduitEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'integer')
            ->add('nom')
            ->add('type', 'entity',array("class"=>"GOShopBundle:TypeProduit", "property"=>"nom", "empty_value"=>"selectionnez un type"))
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
