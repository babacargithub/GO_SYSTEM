<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
/**
 * Description of EventType
 *
 * @author hp
 */
class EvenementType extends \Symfony\Component\Form\AbstractType {
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('libelle', 'text')
                ->add('dateStart', 'date', array('widget'=>'single_text'))
                ->add('dateEnd', 'date', array('widget'=>'single_text'))
               ->add('trajet', 'choice', 
                       array("choices"=>
                            array(1=>"UGB vers DAKAR", 2=>"DAKAR vers UGB"),
                           "expanded"=>false, "multiple"=>false, "empty_value"=>"Trajet de l'évènement"));
           
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\Evenement'
        ));
    }

    public function getName()
    {
        return 'go_caravanebundle_evenementtype';
    }



    }

