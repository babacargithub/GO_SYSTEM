<?php

namespace GO\CaravaneBundle\Form;
use GO\CaravaneBundle\Entity\Depart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BilanDepartType extends AbstractType
{
    protected $depart;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chauffeur','entity',array(
                "class"=>"GOCaravaneBundle:Chauffeur", 
                "property"=>"nomComplet",
                "empty_value"=>"Qui est le chauffeur"))
            ->add('bus')
            ->add('nombreInscrit','integer',array('label'=>"Nombre Inscrit"))
            ->add('nombrePresent','integer',array('label'=>"Nombre Présent"))
            ->add('nombreAbsent','integer',array('label'=>"Nombre Absent")) 
            ->add('encaisse','integer',array('label'=>"Total Encaissé"))
            ->add('location','integer',array('label'=>"Location Bus"))
            ->add('commentaires')
            ->add('agent','entity',array(
                "class"=>"GOMainBundle:Employe", 
                "property"=>"prenom",
                "empty_value"=>"Qui a géré le bus?"))
               ->add('depenses', 'collection', array(
                 'type'=>new DepenseDepartType(), 'allow_add'=>true))
                
         
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GO\CaravaneBundle\Entity\BilanDepart'
        ));
    }

    public function getName()
    {
        return 'go_caravanebundle_bilandeparttype';
    }
    function __construct(Depart $depart) {
        $this->depart=$depart;
    }

}
