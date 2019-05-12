<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GO\ShopBundle\Form\DataTransformer\CodeBarProduitTransformer;
class CodeBarToProduitType extends AbstractType{
    //put your code here
    private $manager;
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CodeBarProduitTransformer($this->manager));
    }
    public function getParent() {
        return "text";
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'Le code barre n\'est associé à aucun produit! ',
        ));
    }
     public function getName()
    {
        return 'code_bar_to_produit';
    }


}
