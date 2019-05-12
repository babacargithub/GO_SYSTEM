<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\ShopBundle\Entity\Inventaire;

class InventaireEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $inventaire=new Inventaire();
        //$inventaire->set
        $builder
            ->add('libelle')
           ->add('dateDebutPeriode')
           ->add('dateFinPeriode')
           ->add("caisse")
           ->add("depense")
           ->add("soldeBanque")
           ->add("capital")
           ->add("CreanceLiquide")
           ->add("CreanceProduit")
           ->add("DetteLiquide")
           ->add("DetteProduit")
            ->add('type')
            ->add('acteurs');
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
