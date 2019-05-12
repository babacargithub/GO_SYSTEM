<?php

namespace  GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
class CodeBarSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder->add('codeBar', 'text', array("label"=>"Code Barre à Chercher",
                 'constraints' => array(
           new NotBlank())))
                 ->add('date_debut', 'date', array('widget'=>"single_text",
                 'required'=>false))
                 ->add('date_fin', 'date', array('widget'=>"single_text",
                         "required"=>false)
                 );
    
    }

    
    public function getName()
    {
        return 'go_shopbundle_stock_code_bar_search_type';
    }
}
