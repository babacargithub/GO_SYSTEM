<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Description of CompanyType
 *
 * @author LBC
 */
class CompanyType extends AbstractType{
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options) {
       $builder
               ->add("nom", null,["label"=>"Nom de Société"])
               ->add("adresse", null,["label"=>"Adresse Société"])
               ->add("gerant", null,["label"=>"Gérant Société"])
               ->add("tel", null,["label"=>"Téléphone Société"])
               ->add("email", null,["label"=>"Email Société"])
               ->add("Enregistrer", Types\SubmitType::class)
               ;
    }

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Company'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_companytype';
    }

    
}
