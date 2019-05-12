<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactureAchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
                ->add('fournisseur','entity',array('class'=>'GOShopBundle:Fournisseur', 'property'=>'nom',"empty_value"=>"Sélectionner fournisseur"))
             ->add('dateFacture', 'date', array('widget'=>"single_text", "label"=>"Date de la Facture"))
            ->add('paye', 'choice', 
                     array
                     ( "choices"=>
                                array(false=>"Non", true=>"Oui"
                                    ),
                     "multiple"=>false, 
                     "expanded"=>true,
                     //"mapped"=>false
                     ))
            ->add('avance')
           
            ->add('livre', 'choice', 
                     array
                     ( "attr"=>array("label"=>"Facture réceptionnée"),"choices"=>
                                array(false=>"Non", true=>"Oui"
                                    ),
                     "multiple"=>false, 
                     "expanded"=>true,
                     ))
            ->add('fraisTransport')
             ->add('achats', 'collection', array(
                 'type'=>new AchatType(), 'allow_add'=>true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\FactureAchat'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_factureachattype';
    }
}
