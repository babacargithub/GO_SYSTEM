<?php

namespace GO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager as EM;
use GO\ClientBundle\Form\CompteClientTransformerType;
use GO\ClientBundle\Form\TelephoneToCompteClientTransformerType;
use GO\ShopBundle\Form\ProduitSelectorType;
class VenteCodeBarType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('produit', 'produit_selector', attr)
            ->add('codeBar', TextType::class)
            ->add('quantite', IntegerType::class)
            ->add('prixUnit', MoneyType::class, array("currency"=>"CFA"))
            ->add('compteClient', CompteClientTransformerType::class, array("label"=>"Numéro compte client","required"=>false, "attr"=>[]))
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
        return 'go_shopbundle_ventecodebartype';
    }
}
