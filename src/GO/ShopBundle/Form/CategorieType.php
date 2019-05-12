<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
             ->add('typeProduit', 'entity', 
                        array('empty_value'=>'Type de produit', 
                    'class'=>"GOShopBundle:TypeProduit", "property"=>"nom", 
                            "label"=>"Type de produit"))
                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Categorie'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_categorietype';
    }
}
