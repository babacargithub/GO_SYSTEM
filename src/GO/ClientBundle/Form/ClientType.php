<?php

namespace GO\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\ClientBundle\Entity\CategorieClient;

class ClientType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstName', Type\TextType::class, array("label" => "Prénom"))
        ->add('lastName', Type\TextType::class, array("label" => "Nom"))
        ->add('tel', Type\IntegerType::class, array("label" => "Téléphone"))
        ->add('email', Type\EmailType::class, ["required"=>false])
        ->add('adresse', Type\TextType::class,["required"=>false])
        ->add('sexe', Type\ChoiceType::class, array("choices" => array("F" => "Féminin", "M" => "Masculin"), "placeholder" => "Choisir le Sexe"))
        ->add('categorie', EntityType::class, array("label"=>"Catégorie","class"=> CategorieClient::class,"property"=>"name", "placeholder"=>"Catégorie de Client(e)"));
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ClientBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'go_clientbundle_client';
    }

}
