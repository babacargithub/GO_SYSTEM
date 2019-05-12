<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager as EM;
use GO\ClientBundle\Form\CompteClientTransformerType;
use GO\ShopBundle\Form\ProduitSelectorType;
class VenteType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', ProduitSelectorType::class, array('attr'=>array('class'=>'auto_com')))
            ->add('quantite')
            ->add('prixUnit', IntegerType::class, array("label"=>"Prix de Vente"))
            ->add('compteClient', CompteClientTransformerType::class, array("label"=>"Numéro Compte du Client","attr"=>array("required"=>false)));
                }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\ShopBundle\Entity\Vente'
        ));
    }

    public function getBlockPrefix()
    {
        return 'go_shopbundle_ventetype';
    }
}
