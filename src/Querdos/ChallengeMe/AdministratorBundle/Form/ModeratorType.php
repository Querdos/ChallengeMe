<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeratorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',   TextType::class,        array(
                'label' => 'Username',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'  => 'required',
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true
            ))
            ->add('plain_password',   PasswordType::class,    array(
                'label' => 'Password',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'  => 'required',
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true
            ))
            ->add('email',      EmailType::class,       array(
                'label' => 'Main Email',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'  => 'required',
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true
            ))
            ->add('emailBack',  EmailType::class,       array(
                'label' => 'Secondary email',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'  => 'required',
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true
            ))
            ->add('infoUser', InfoUserType::class, array(
                'label'     => ''
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator'
        ));
    }
}
