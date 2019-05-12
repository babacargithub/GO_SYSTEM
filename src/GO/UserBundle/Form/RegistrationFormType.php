<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
   // private $class;

    /**
     
     
    public function __construct($class)
    {
        $this->class = $class;
    }*/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('prenom', 'text');
        $builder->add('nom', 'text');
        $builder->add('tel', 'text')
       ->add('roles', 'choice', array(
                //'mapped' => false,
                "multiple" => true,
                'required' => true,
                'label'    => 'Role',
                'choices' => array(
                    'ROLE_AG_BOUT' => 'BOUTIQUIER',
                    'ROLE_AG_CARAV' => 'AGENT CARAVANE',
                    'ROLE_SUP_BOUT' => 'SUPERVISEUR BOUTIQUE',
                    'ROLE_CONTROLEUR' => 'CONROLEUR',
                    'ROLE_ADMIN' => 'ADMIN',
                    'ROLE_SUP_ADMIN' => 'SUP ADMIN',
                ),
                'expanded'   => false,
            ))->add('apps', 'choice', array(
                'mapped' => false,
                "multiple" => true,
                'required' => true,
                'label'    => 'Service Affecté',
                'choices' => array(
                    'APP_CARAVANE' => 'CARAVANE',
                    'APP_SHOP' => 'BOUTIQUE',
                    'APP_SMS' => 'SMS',
                    'APP_EXPRESS' => 'EXPRESS',
                    'APP_RESO' => 'RESTAURANT',
                    'APP_ADMIN' => 'ADMIN',
                    
                ),
                'expanded'   => false,
            ))->add('level', 'text');
        $builder->add('enLigneUser', 'text');
        
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }
     

    public function getName()
    {
        return 'go_user_registration';
    }
}
