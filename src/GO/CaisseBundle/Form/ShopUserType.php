<?php

namespace GO\CaisseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ShopUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('shop',EntityType::class, array("label"=>"Boutique", "class"=>"GO\CaisseBundle\Entity\Shop", "placeholder"=>"Sélectionner Une Boutique"))
                ->add('user',EntityType::class, array('class'=>"GO\UserBundle\Entity\User","placeholder"=>"Préciser l'utilisateur", "property"=>"Prenom"));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaisseBundle\Entity\ShopUser'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'go_caissebundle_shopuser';
    }


}
