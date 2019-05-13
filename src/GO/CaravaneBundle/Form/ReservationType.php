<?php

namespace GO\CaravaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\CaravaneBundle\Form\ClientType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', TelephoneToClientTransformerType::class)
            ->add('depart', EntityType::class,array(
                "class"=>"GOCaravaneBundle:Depart", 
                "property"=>"libelle",
                "empty_value"=>"Sélectionner un départ",
               'query_builder'=> function(\GO\CaravaneBundle\Entity\DepartRepository $r){return $r->getListeDeparts();}
                 ))
            ->add('pointDep', EntityType::class, array(
                "class"=>"GOCaravaneBundle:PointDepart", 
                "property"=>"nom",
                "empty_value"=>"Choisir Point de départ",
                'query_builder'=> function(\GO\CaravaneBundle\Entity\PointDepartRepository $r){return $r->getListePointDeparts();}
                 ))
            ->add('des', EntityType::class, array(
                "class"=>"GOCaravaneBundle:Destination", 
                "property"=>"libelle",
                "empty_value"=>"Select une destination"))
            
             ->add('paye', ChoiceType::class, 
                     array
                     ( "choices"=>[false=>"Non", true=>"Oui"],
                                    
                     "multiple"=>false, 
                     "expanded"=>true,
                     "mapped"=>false
                     ))
                
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\Reservation'
        ));
    }

    public function getName()
    {
        return 'go_caravanebundle_reservationtype';
    }
}
