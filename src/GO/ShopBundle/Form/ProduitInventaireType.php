<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;
use GO\ShopBundle\Form\ProduitSelectorType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduitInventaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('produit', ProduitSelectorType::class, array("attr"=>array("class"=>"auto_com")))
            ->add('codeBar', TextType::class)
           ->add('stockReel', IntegerType::class)
            ->add('prixAchat', MoneyType::class, array("currency"=>"XOF","required"=>false))
            ->add('prixVente', MoneyType::class,array("currency"=>"XOF","required"=>false))
           
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\ProduitInventaire'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_produitinventairetype';
    }
}
