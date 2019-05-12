<?php

namespace GO\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', Type\TextType::class, array("label"=>"Nom de la Catégorie"))
                ->add('abrv',Type\TextType::class, array("label"=>"Abbréviation Catégorie"))
                ->add('comments', Type\TextareaType::class, array("label"=>"Description Catégorie"));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ClientBundle\Entity\CategorieClient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'go_clientbundle_categorieclient';
    }


}
