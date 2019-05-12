<?php

namespace GO\CaravaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\MainBundle\Form\ClientType;
class ReservationEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              
            ->add('client', new ClientType())
            ->add('depart', 'entity',array(
                "class"=>"GOCaravaneBundle:Depart", 
                "property"=>"libelle",
                "empty_value"=>"Sélectionner un départ",
               'query_builder'=> function(\GO\CaravaneBundle\Entity\DepartRepository $r){return $r->getListeDeparts();}
                 ))
            ->add('pointDep', 'entity', array(
                "class"=>"GOCaravaneBundle:PointDepart", 
                "property"=>"nom",
                "empty_value"=>"Choisir Point de départ",
                'query_builder'=> function(\GO\CaravaneBundle\Entity\PointDepartRepository $r){return $r->getListePointDeparts();}
                 ))
            ->add('des', 'entity', array(
                "class"=>"GOCaravaneBundle:Destination", 
                "property"=>"libelle",
                "empty_value"=>"Select une destination"), array('required'=>true))
                 //->add('destination', new DestinationType())
            //->add('depart', new DepartType())
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
