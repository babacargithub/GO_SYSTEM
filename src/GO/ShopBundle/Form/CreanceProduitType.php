<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;
use GO\MainBundle\Form\DataTransformer\TelephoneToClientTransformer;
class CreanceProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', 'produit_selector')
                ->add('quantite')
            ->add('client', 'client_selector')
            ->add('dateEcheance')
            ->add('prixUnit')
            
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\CreanceProduit'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_creanceproduittype';
    }
}
