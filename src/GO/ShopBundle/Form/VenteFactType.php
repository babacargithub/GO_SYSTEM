<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager as EM;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;
class VenteFactType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            //->add('produit','entity', array('class'=>"GOShopBundle:Produit", "empty_value"=>"Selectionner un produit", "property"=>"nom",'query_builder'=> function(\GO\ShopBundle\Entity\ProduitRepository $r){return $r->getListe();}))
             ->add('codeBar', 'text',array("label"=>"Code Bar", "required"=>false))
             ->add('produit', 'produit_selector', array("required"=>false,'attr'=>array("class"=>"auto_com")))
             ->add('quantite')
            ->add('prixUnit', 'text', array("attr"=>array("class"=>"montant")));
        }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Vente'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_ventetype';
    }
}
