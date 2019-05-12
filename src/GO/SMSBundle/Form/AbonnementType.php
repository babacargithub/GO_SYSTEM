<?php

namespace GO\SMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\DataTransformer\TelephoneToClientTransformer;
class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', 'client_selector', array("label"=>"Téléphone Client"))
            ->add('formule', 'entity', array('class'=>"GOSMSBundle:Formule", "property"=>"libelle", "empty_value"=>"Sélectionnez la formule"))
            //->add('challenger')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\SMSBundle\Entity\Abonnement'
        ));
    }

    public function getName()
    {
        return 'go_smsbundle_abonnementtype';
    }
}
