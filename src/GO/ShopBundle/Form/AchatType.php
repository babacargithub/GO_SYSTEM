<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeBar','text',array("label"=>"Code Bar", "required"=>false))
            ->add('produit', 'produit_selector', array('attr'=>array("class"=>"auto_com", "autocomplete"=>"off")))
             ->add('quantite')
            ->add('prixUnit')
            ->add('prixVente')
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Achat'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_achattype';
    }
}
