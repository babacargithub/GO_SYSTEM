<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class TransfertProduitType extends AbstractType
{
    protected $session;
    public function __construct(Session $session) {
        $this->session=$session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
    ->add('paye')
    ->add('destinataire', 'entity', array('class'=>"GOShopBundle:Shop", 
        "empty_value"=>"Sélectionnez Destinataire", 
        "property"=>"libelle",
        'query_builder'=> function(\GO\ShopBundle\Entity\ShopRepository $r){return $r->getOtherShops($this->session);}))
     ->add('produitTransferes', 'collection', array(
                 'type'=>new ProduitTransfereType(), 'allow_add'=>true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\TransfertProduit'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_transfertproduittype';
    }
}
