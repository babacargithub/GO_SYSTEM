<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\DataTransformer\TelephoneToClientTransformer;

class FactureVenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('client','entity',array('class'=>'GOShopBundle:ClientRevendeur', 'property'=>'nom',"empty_value"=>"Sélectionner Client"))
            ->add('date', 'date', array('widget'=>"single_text", "label"=>"Date de la Facture"))
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
                     ( "attr"=>array("label"=>"Facture livrée"),"choices"=>
                                array(false=>"Non", true=>"Oui"
                                    ),
                     "multiple"=>false, 
                     "expanded"=>true,
                     //"mapped"=>false
                     ))
             ->add('ventes', 'collection', array(
                 'type'=>new VenteFactType(), 'allow_add'=>true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\FactureVente'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_factureventetype';
    }
}
