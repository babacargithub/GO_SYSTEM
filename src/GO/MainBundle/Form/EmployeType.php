<?php

namespace GO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('tel')
            ->add('email')
            ->add('adresse')
            ->add('poste')
            ->add('salaire')
            ->add('dateEmbauche')
            ->add('statut')
            ->add('actif')
            ->add('suspendu')
            ->add('dateNaissance')
            ->add('cni')
            ->add('dateDelivCni')
            ->add('dateExpCni')
            ->add('sexe')
            ->add('cvUrl')
            ->add('photoProfilUrl')
            ->add('typeContrat')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\MainBundle\Entity\Employe'
        ));
    }

    public function getName()
    {
        return 'go_mainbundle_employetype';
    }
}
