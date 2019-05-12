<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduitTransfereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite')
            ->add('produit', 'entity', array('class'=>"GOShopBundle:Produit", "property"=>"nom","empty_value"=>"Sélectionnez produit", 
            'query_builder'=> function(\GO\ShopBundle\Entity\ProduitRepository $r){return $r->getListe();})
    )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\ProduitTransfere'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_produittransferetype';
    }
}
