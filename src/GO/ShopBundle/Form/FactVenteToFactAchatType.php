<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use GO\ShopBundle\Entity\Shop;
class FactVenteToFactAchatType extends AbstractType
{
    protected $shop;
    protected $session;
    public function __construct($session) {
        $this->session=$session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('shop', 'entity', array(
                'class'=>'GOShopBundle:Shop', 
                'property'=>'libelle', 
                'empty_value'=>'Sélectionner un shop', 
                'query_builder'=> function(\GO\ShopBundle\Entity\ShopRepository $r){return $r->getOtherShops($this->session);}
               ))->add('paye', 'choice', 
                     array
                     ( "choices"=>
                                array(false=>"Non", true=>"Oui"
                                    ),
                     "multiple"=>false, 
                     "expanded"=>true,
                     //"mapped"=>false
                     ));
                }


    public function getName()
    {
        return 'go_shopbundle_ventefacttofactachattype';
    }
}
