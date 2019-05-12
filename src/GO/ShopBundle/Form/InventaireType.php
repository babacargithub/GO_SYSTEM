<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InventaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('dateDebutPeriode')
            ->add('dateFinPeriode')
           
            ->add('type')
            
            ->add('acteurs')
            
            ->add('inventairePrecedent')
                 ->add('produits', 'collection', array(
                  'type'=>new ProduitInventaireType(), 'allow_add'=>true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Inventaire'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_inventairetype';
    }
}
