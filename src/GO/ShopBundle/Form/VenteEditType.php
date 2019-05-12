<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager as EM;
use GO\ShopBundle\Form\DataTransformer\ProduitTransformer;
class VenteEditType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', 'produit_selector')
            ->add('quantite')
            ->add('prixUnit', 'text', array("attr"=>array("class"=>"montant")))
          ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Vente'
        ));
    }

    public function getName()
    {
        return 'go_shopbundle_venteedittype';
    }
}
