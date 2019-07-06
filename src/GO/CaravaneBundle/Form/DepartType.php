<?php

namespace GO\CaravaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GO\CaravaneBundle\Entity\Depart;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', array('label'=>'Libellé du départ'))
            ->add('date', 'date', array("widget"=>"single_text"))
            ->add('trajet', 'choice', array("choices"=>array(1=>"UGB vers DAKAR", 2=>"DAKAR vers UGB"), "expanded"=>false, "multiple"=>false, "empty_value"=>"Trajet du départ"))
            ->add('horaire', 'choice', array("choices"=>array(1=>"Depart NUIT", 2=>"Depart APRES-MIDI"), "expanded"=>false, "multiple"=>false, "empty_value"=>"Horaire du départ"))
            ->add("visibilite", ChoiceType::class,["label"=>"Départ visible?","choices"=>[Depart::VISIBILITY_ALL=>"A TOUT LE MONDE",Depart::VISIBILITY_STAFF=>"AU PERSONNEL",]])
            ->add('event', 'entity', array(
                'class'=>'GOCaravaneBundle:Evenement', 
                'property'=>'libelle',
                "empty_value"=>"Evènement départ",
                "query_builder"=>function(\GO\CaravaneBundle\Entity\EvenementRepository $r){
            return $r->getEventsEncours();
                }
                ))
                 ->add('heuresDepart', 'collection', array(
                 'type'=>new HeureDepartType(), 'allow_add'=>true))
                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\Depart'
        ));
    }

    public function getName()
    {
        return 'go_caravanebundle_departtype';
    }
}
